@extends('layouts.customer')

@section('title', 'Dashboard Pelanggan')

@section('content')
<div class="mb-8 mt-6">
    <h1 class="text-3xl font-extrabold text-slate-900">Halo, {{ Auth::user()->name }}! 👋</h1>
    <p class="text-slate-500 mt-2">Selamat datang di dashboard Anda. Berikut adalah riwayat pesanan Anda.</p>
</div>

@if (session('success'))
    <div class="alert alert-success bg-green-50 border border-green-200 text-green-800 shadow-sm mb-6 rounded-2xl">
        <span>{{ session('success') }}</span>
    </div>
@endif

<div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-3xl border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-100">
        <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
            Riwayat Pesanan
        </h2>
    </div>
    
    @if($orders->count() > 0)
        <div class="overflow-x-auto">
            <table class="table w-full text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="py-4">ID Order</th>
                        <th class="py-4">Tanggal</th>
                        <th class="py-4">Total Tagihan</th>
                        <th class="py-4">Status Pembayaran</th>
                        <th class="py-4">Status Pesanan</th>
                        <th class="py-4">Resi / Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($orders as $order)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-4 font-bold text-slate-900">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td class="py-4 text-slate-500">{{ $order->created_at->format('d M Y, H:i') }}</td>
                        <td class="py-4 font-bold text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td class="py-4">
                            @if($order->payment->status === 'menunggu')
                                <span class="bg-amber-100 text-amber-800 text-xs font-semibold px-2.5 py-1 rounded-full border border-amber-200">Menunggu</span>
                            @elseif($order->payment->status === 'berhasil')
                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-1 rounded-full border border-green-200">Berhasil (Lunas)</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-1 rounded-full border border-red-200">Batal / Gagal</span>
                            @endif
                        </td>
                        <td class="py-4">
                            <span class="bg-slate-100 text-slate-700 text-xs font-semibold px-2.5 py-1 rounded-full border border-slate-200 capitalize">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="py-4">
                            @if($order->payment->status === 'menunggu')
                                <a href="{{ route('checkout.payment', $order->id) }}" class="btn btn-sm btn-primary rounded-full shadow-sm text-xs px-4">Bayar Sekarang</a>
                            @else
                                @if($order->tracking_number)
                                    <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">No. Resi</div>
                                    <div class="font-mono text-sm font-bold bg-slate-100 px-2 py-1 rounded-md inline-block">{{ $order->tracking_number }}</div>
                                @else
                                    <span class="text-slate-400 italic text-sm">Belum ada resi</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-16">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Belum ada pesanan</h3>
            <p class="text-slate-500 mb-6">Anda belum pernah melakukan pemesanan bibit ikan.</p>
            <a href="{{ route('catalog') }}" class="btn btn-primary rounded-full px-8 shadow-lg shadow-primary/30">Mulai Belanja</a>
        </div>
    @endif
</div>
@endsection
