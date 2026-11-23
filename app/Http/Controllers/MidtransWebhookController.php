<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Stock;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    public function handler(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        
        $orderId = $request->order_id;
        $statusCode = $request->status_code;
        $grossAmount = $request->gross_amount;
        $signatureKey = $request->signature_key;

        $hashed = hash("sha512", $orderId . $statusCode . $grossAmount . $serverKey);

        if ($hashed != $signatureKey) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // Midtrans sandbox appends timestamp to order_id, e.g., 1-1710000000
        $realOrderId = explode('-', $orderId)[0];
        
        $transactionStatus = $request->transaction_status;
        $paymentType = $request->payment_type;
        $fraudStatus = $request->fraud_status;

        $order = Order::find($realOrderId);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $payment = $order->payment;
        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        // If payment is already successful, ignore to prevent duplicate stock reduction
        if ($payment->status === 'berhasil') {
            return response()->json(['message' => 'Payment already processed']);
        }

        DB::beginTransaction();
        try {
            if ($transactionStatus == 'capture') {
                if ($paymentType == 'credit_card') {
                    if ($fraudStatus == 'challenge') {
                        $payment->update(['status' => 'menunggu']);
                    } else {
                        $payment->update(['status' => 'berhasil', 'paid_at' => now(), 'midtrans_transaction_id' => $request->transaction_id]);
                        $this->onPaymentSuccess($order);
                    }
                }
            } else if ($transactionStatus == 'settlement') {
                $payment->update(['status' => 'berhasil', 'paid_at' => now(), 'midtrans_transaction_id' => $request->transaction_id]);
                $this->onPaymentSuccess($order);
            } else if ($transactionStatus == 'pending') {
                $payment->update(['status' => 'menunggu']);
            } else if ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
                $payment->update(['status' => $transactionStatus == 'expire' ? 'kedaluwarsa' : 'gagal']);
                $order->update(['status' => 'dibatalkan']);
            }
            
            DB::commit();
            return response()->json(['message' => 'Webhook processed']);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Midtrans Webhook Error: ' . $e->getMessage());
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }

    private function onPaymentSuccess(Order $order)
    {
        $order->update(['status' => 'diproses']);

        foreach ($order->items as $item) {
            $stock = Stock::firstOrCreate(
                ['fish_seed_size_id' => $item->fish_seed_size_id],
                ['quantity' => 0]
            );
            
            $stock->decrement('quantity', $item->quantity);

            StockMovement::create([
                'fish_seed_size_id' => $item->fish_seed_size_id,
                'type' => 'out',
                'quantity' => $item->quantity,
                'note' => 'Penjualan Order #' . $order->id . ' (Midtrans)',
            ]);
        }
    }
}
