<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Stock;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Get user's last address if any
        $lastAddress = Address::where('user_id', Auth::id())->latest()->first();

        return view('checkout.index', compact('cart', 'total', 'lastAddress'));
    }

    public function process(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'full_address' => 'required|string',
            'postal_code' => 'nullable|string|max:10',
            'expedition_name' => 'required|string|max:255',
            'shipping_service' => 'required|string|max:255',
            'shipping_cost' => 'required|numeric|min:0',
        ]);

        $order = DB::transaction(function () use ($validated, $cart) {
            // 1. Create Address
            $address = Address::create([
                'user_id' => Auth::id(),
                'recipient_name' => $validated['recipient_name'],
                'phone' => $validated['phone'],
                'full_address' => $validated['full_address'],
                'postal_code' => $validated['postal_code'],
            ]);

            // 2. Calculate Total
            $totalAmount = 0;
            foreach ($cart as $item) {
                $totalAmount += $item['price'] * $item['quantity'];
            }

            // 3. Create Order
            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => 'pending',
                'total_amount' => $totalAmount + $validated['shipping_cost'], // Include shipping cost
                'shipping_address_id' => $address->id,
                'expedition_name' => strtoupper($validated['expedition_name']),
                'shipping_service' => $validated['shipping_service'],
                'shipping_cost' => $validated['shipping_cost'],
            ]);

            // 4. Create Order Items
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'fish_seed_size_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            // 5. Create Payment with Midtrans Snap Token
            $payment = Payment::create([
                'order_id' => $order->id,
                'method' => 'Midtrans',
                'status' => 'menunggu',
            ]);

            // Set Midtrans configuration
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production');
            \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
            \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

            $items = [];
            foreach ($cart as $item) {
                $items[] = [
                    'id' => $item['id'],
                    'price' => (int) $item['price'],
                    'quantity' => $item['quantity'],
                    'name' => mb_substr($item['name'], 0, 50),
                ];
            }
            if ($validated['shipping_cost'] > 0) {
                $items[] = [
                    'id' => 'SHIPPING',
                    'price' => (int) $validated['shipping_cost'],
                    'quantity' => 1,
                    'name' => 'Ongkos Kirim (' . mb_substr($validated['expedition_name'], 0, 20) . ')',
                ];
            }

            $midtransOrderId = $order->id . '-' . time();
            $params = [
                'transaction_details' => [
                    'order_id' => $midtransOrderId, // Append time to avoid duplicate order ID in sandbox
                    'gross_amount' => (int) ($totalAmount + $validated['shipping_cost']),
                ],
                'customer_details' => [
                    'first_name' => mb_substr($validated['recipient_name'], 0, 50),
                    'phone' => $validated['phone'],
                    'email' => Auth::user()->email,
                    'shipping_address' => [
                        'first_name' => mb_substr($validated['recipient_name'], 0, 50),
                        'phone' => $validated['phone'],
                        'address' => mb_substr($validated['full_address'], 0, 200),
                        'postal_code' => mb_substr($validated['postal_code'], 0, 10),
                    ]
                ],
                'item_details' => $items,
            ];

            try {
                $snapToken = \Midtrans\Snap::getSnapToken($params);
                $payment->update([
                    'snap_token' => $snapToken,
                    'qris_reference' => $midtransOrderId,
                ]);
            } catch (\Throwable $e) {
                \Log::error('Midtrans Error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
                // Silently fail for now, snap_token will be null and view will show error
            }

            return $order;
        });

        session()->forget('cart');

        return redirect()->route('checkout.payment', $order->id)->with('success', 'Pesanan berhasil dibuat. Silakan lakukan pembayaran.');
    }

    public function payment(Order $order)
    {
        if ($order->user_id !== Auth::id()) abort(403);
        
        $payment = $order->payment;

        // Auto sync status from Midtrans if still waiting and has reference
        if ($payment && $payment->status === 'menunggu' && !empty($payment->qris_reference)) {
            $this->syncMidtransStatus($order, $payment);
            $payment->refresh();
        }

        // If payment is still waiting and snap_token is empty or missing, regenerate it
        if ($payment && $payment->status === 'menunggu' && empty($payment->snap_token)) {
            $this->generateSnapTokenForOrder($order, $payment);
            $payment->refresh();
        }

        return view('checkout.payment', compact('order', 'payment'));
    }

    private function generateSnapTokenForOrder(Order $order, Payment $payment)
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

        $items = [];
        $itemsTotal = 0;
        foreach ($order->items as $item) {
            $itemsTotal += $item->price * $item->quantity;
            $items[] = [
                'id' => $item->fish_seed_size_id,
                'price' => (int) $item->price,
                'quantity' => $item->quantity,
                'name' => mb_substr($item->fishSeedSize->fishSeed->name ?? ('Item ' . $item->id), 0, 50),
            ];
        }

        if ($order->shipping_cost > 0) {
            $items[] = [
                'id' => 'SHIPPING',
                'price' => (int) $order->shipping_cost,
                'quantity' => 1,
                'name' => 'Ongkos Kirim (' . mb_substr($order->expedition_name ?? 'Kurir', 0, 20) . ')',
            ];
        }

        $midtransOrderId = $order->id . '-' . time();
        $params = [
            'transaction_details' => [
                'order_id' => $midtransOrderId,
                'gross_amount' => (int) ($itemsTotal + $order->shipping_cost),
            ],
            'customer_details' => [
                'first_name' => mb_substr($order->shippingAddress->recipient_name ?? Auth::user()->name, 0, 50),
                'phone' => $order->shippingAddress->phone ?? '',
                'email' => Auth::user()->email,
            ],
            'item_details' => $items,
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $payment->update([
                'snap_token' => $snapToken,
                'qris_reference' => $midtransOrderId,
            ]);
        } catch (\Throwable $e) {
            \Log::error('Regenerate Snap Token Error: ' . $e->getMessage());
        }
    }

    private function syncMidtransStatus(Order $order, Payment $payment)
    {
        try {
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production');

            $status = \Midtrans\Transaction::status($payment->qris_reference);
            if ($status) {
                $transactionStatus = $status->transaction_status ?? null;
                $fraudStatus = $status->fraud_status ?? null;
                $paymentType = $status->payment_type ?? null;

                if ($transactionStatus == 'capture') {
                    if ($paymentType == 'credit_card' && $fraudStatus == 'challenge') {
                        $payment->update(['status' => 'menunggu']);
                    } else {
                        $payment->update([
                            'status' => 'berhasil',
                            'paid_at' => now(),
                            'midtrans_transaction_id' => $status->transaction_id ?? null,
                        ]);
                        $this->onPaymentSuccess($order);
                    }
                } else if ($transactionStatus == 'settlement') {
                    $payment->update([
                        'status' => 'berhasil',
                        'paid_at' => now(),
                        'midtrans_transaction_id' => $status->transaction_id ?? null,
                    ]);
                    $this->onPaymentSuccess($order);
                } else if (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                    $payment->update(['status' => $transactionStatus == 'expire' ? 'kedaluwarsa' : 'gagal']);
                    $order->update(['status' => 'dibatalkan']);
                }
            }
        } catch (\Throwable $e) {
            // Transaction might not exist yet if user hasn't completed payment in Midtrans
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
