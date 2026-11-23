@extends('layouts.admin')

@section('title', 'Kelola Pesanan')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold">Daftar Pesanan</h1>
</div>

@if (session('success'))
    <div class="alert alert-success shadow-sm mb-4">
        <span>{{ session('success') }}</span>
    </div>
@endif

<div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-3xl border border-slate-100 overflow-x-auto">
    <table class="table w-full">
        <thead>
            <tr>
                <th>ID</th>
                <th>Pelanggan</th>
                <th>Total Tagihan</th>
                <th>Pembayaran</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td>{{ $order->user->name }}</td>
                <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                <td>
                    @if($order->payment->status === 'berhasil')
                        <span class="badge badge-success gap-2">Lunas</span>
                    @else
                        <span class="badge badge-warning gap-2">{{ ucfirst($order->payment->status) }}</span>
                    @endif
                </td>
                <td>
                    <span class="badge badge-outline">{{ ucfirst($order->status) }}</span>
                </td>
                <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                <td>
                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info">Detail / Proses</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-4">Belum ada pesanan masuk.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
