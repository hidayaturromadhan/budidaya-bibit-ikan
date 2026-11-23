@extends('layouts.app')

@section('title', 'Pembayaran QRIS')

@section('content')
<div class="max-w-2xl mx-auto mt-12 mb-16">
    <div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.08)] rounded-3xl border border-slate-100 overflow-hidden relative">
        <!-- Decorative Header -->
        <div class="h-4 bg-gradient-to-r from-primary to-blue-400 w-full"></div>
        
        <div class="p-4 sm:p-8 text-center">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-2">Selesaikan Pembayaran</h2>
            <p class="text-slate-500 mb-8 font-medium">Order ID: <span class="text-slate-800 font-bold">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span></p>

            @if (session('success'))
                <div class="alert alert-success bg-green-50 border border-green-200 text-green-800 shadow-sm mb-6 rounded-2xl">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('info'))
                <div class="alert alert-info bg-blue-50 border border-blue-200 text-blue-800 shadow-sm mb-6 rounded-2xl">
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            <div class="mb-8">
                <p class="text-sm text-slate-500 max-w-md mx-auto">Selesaikan pembayaran pesanan Anda menggunakan berbagai metode pembayaran yang didukung oleh Midtrans (QRIS, GoPay, Transfer Bank, dll).</p>
            </div>
            <div class="mb-8 bg-slate-50 p-6 rounded-2xl border border-slate-100 text-left max-w-md mx-auto">
                <div class="flex justify-between mb-2 text-sm text-slate-600">
                    <span>Subtotal Produk:</span>
                    <span class="font-semibold text-slate-800">Rp {{ number_format($order->total_amount - $order->shipping_cost, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between mb-4 text-sm text-slate-600 border-b border-slate-200 pb-4">
                    <span>Ongkos Kirim ({{ $order->expedition_name }} - {{ $order->shipping_service }}):</span>
                    <span class="font-semibold text-slate-800">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm font-semibold uppercase tracking-wider text-slate-500">Total Tagihan</span>
                    <span class="text-3xl font-black text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
            @if($payment->status === 'menunggu')
                @if($payment->snap_token)
                    <button id="pay-button" class="btn btn-primary w-full max-w-sm rounded-full shadow-lg shadow-blue-500/30 text-white border-0 hover:bg-blue-700 group text-lg h-14">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        Bayar Sekarang
                    </button>
                    <p class="text-xs text-slate-400 mt-4">*Anda akan diarahkan ke halaman pembayaran aman Midtrans.</p>
                @else
                    <div class="alert alert-error bg-red-50 text-red-600 rounded-xl border border-red-200">
                        Maaf, terjadi kesalahan saat menghubungi payment gateway. Silakan muat ulang halaman.
                    </div>
                @endif
            @else
                <div class="bg-green-50 border border-green-200 p-6 rounded-2xl flex flex-col items-center justify-center mb-6">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center text-green-600 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-green-800">Pembayaran Berhasil!</h3>
                    <p class="text-green-700 mt-1">Terima kasih, pesanan Anda sedang kami proses.</p>
                </div>
                <a href="{{ route('dashboard') }}" class="btn btn-outline btn-primary rounded-full px-8">Kembali ke Dashboard</a>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
@if($payment->status === 'menunggu' && $payment->snap_token)
<script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const payButton = document.getElementById('pay-button');
        if (payButton) {
            payButton.addEventListener('click', function () {
                snap.pay('{{ $payment->snap_token }}', {
                    onSuccess: function(result){
                        window.location.href = "{{ route('dashboard') }}";
                    },
                    onPending: function(result){
                        // Do nothing, let user wait
                    },
                    onError: function(result){
                        alert("Pembayaran gagal!");
                    },
                    onClose: function(){
                        // User closed popup
                    }
                });
            });
        }
    });
</script>
@endif
@endpush
