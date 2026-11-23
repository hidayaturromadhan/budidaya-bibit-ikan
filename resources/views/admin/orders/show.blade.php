@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Detail Pesanan #{{ $order->id }}</h1>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost">Kembali</a>
</div>

@if (session('success'))
    <div class="alert alert-success shadow-sm mb-4">
        <span>{{ session('success') }}</span>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="col-span-2">
        <!-- Rincian Produk -->
        <div class="card bg-base-100 shadow-xl mb-6">
            <div class="card-body">
                <h2 class="card-title border-b pb-2">Produk Dipesan</h2>
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Ukuran</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->fishSeedSize->fishSeed->name }}</td>
                                <td>{{ $item->fishSeedSize->size_label }}</td>
                                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-right mt-4 text-xl font-bold">
                    Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <!-- Update Status Form -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title border-b pb-2">Update Status Pesanan</h2>
                <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text">Ubah Status</span></label>
                            <select name="status" class="select select-bordered w-full" required>
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending (Menunggu Pembayaran)</option>
                                <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }}>Diproses (Sudah Lunas)</option>
                                <option value="dikemas" {{ $order->status == 'dikemas' ? 'selected' : '' }}>Dikemas</option>
                                <option value="dikirim" {{ $order->status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="dibatalkan" {{ $order->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>
                        
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text">Nomor Resi (Jika dikirim)</span></label>
                            <input type="text" name="tracking_number" value="{{ old('tracking_number', $order->tracking_number) }}" class="input input-bordered w-full" placeholder="Masukkan No Resi..." />
                        </div>
                    </div>
                    
                    <div class="mt-4 text-right">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Info Pelanggan & Pengiriman -->
    <div>
        <div class="card bg-base-100 shadow-xl mb-6">
            <div class="card-body">
                <h2 class="card-title border-b pb-2">Informasi Pengiriman</h2>
                <div class="space-y-2 mt-2">
                    <p><strong>Penerima:</strong> {{ $order->address->recipient_name }}</p>
                    <p><strong>Telepon:</strong> {{ $order->address->phone }}</p>
                    <p><strong>Alamat:</strong> {{ $order->address->full_address }}</p>
                    <p><strong>Kode Pos:</strong> {{ $order->address->postal_code ?? '-' }}</p>
                    <p><strong>Ekspedisi:</strong> {{ $order->expedition_name }}</p>
                </div>
            </div>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title border-b pb-2">Status Pembayaran</h2>
                <div class="space-y-2 mt-2">
                    <p><strong>Metode:</strong> {{ $order->payment->method }}</p>
                    <p><strong>Ref:</strong> {{ $order->payment->qris_reference }}</p>
                    <p>
                        <strong>Status:</strong> 
                        @if($order->payment->status === 'berhasil')
                            <span class="badge badge-success text-white">Lunas</span>
                        @else
                            <span class="badge badge-warning">{{ ucfirst($order->payment->status) }}</span>
                        @endif
                    </p>
                    @if($order->payment->paid_at)
                        <p><strong>Dibayar Pada:</strong> {{ $order->payment->paid_at->format('d M Y H:i:s') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
