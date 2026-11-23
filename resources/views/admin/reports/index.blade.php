@extends('layouts.admin')

@section('title', 'Laporan Penjualan & Stok')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold">Laporan Penjualan & Stok</h1>
</div>

<!-- Filter Box -->
<div class="card bg-base-100 shadow-xl mb-6">
    <div class="card-body">
        <form action="{{ route('admin.reports.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="form-control">
                <label class="label"><span class="label-text">Tanggal Mulai</span></label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="input input-bordered" />
            </div>
            <div class="form-control">
                <label class="label"><span class="label-text">Tanggal Akhir</span></label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="input input-bordered" />
            </div>
            <button type="submit" class="btn btn-primary">Tampilkan Laporan</button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Laporan Penjualan -->
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title border-b pb-2 justify-between">
                <span>Penjualan</span>
                <span class="text-primary font-bold">Total: Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
            </h2>
            <div class="overflow-x-auto mt-2">
                <table class="table table-xs w-full">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Order ID</th>
                            <th>Status</th>
                            <th>Nilai (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                        <tr>
                            <td>{{ $sale->created_at->format('d/m/Y') }}</td>
                            <td>#{{ $sale->id }}</td>
                            <td>{{ ucfirst($sale->status) }}</td>
                            <td>{{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-2">Tidak ada data penjualan pada periode ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Laporan Pergerakan Stok -->
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title border-b pb-2">Pergerakan Stok</h2>
            <div class="overflow-x-auto mt-2">
                <table class="table table-xs w-full">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Bibit (Ukuran)</th>
                            <th>Jenis</th>
                            <th>Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stockMovements as $mv)
                        <tr>
                            <td>{{ $mv->created_at->format('d/m/Y') }}</td>
                            <td>{{ $mv->fishSeedSize->fishSeed->name }} ({{ $mv->fishSeedSize->size_label }})</td>
                            <td>
                                @if($mv->type == 'in') <span class="text-success">Masuk</span> @else <span class="text-error">Keluar</span> @endif
                            </td>
                            <td>{{ $mv->quantity }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-2">Tidak ada pergerakan stok pada periode ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
