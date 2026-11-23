@extends('layouts.admin')

@section('title', 'Riwayat Pergerakan Stok')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold">Riwayat Stok: {{ $size->fishSeed->name }} ({{ $size->size_label }})</h1>
        <p class="text-gray-500 mt-2">Stok Saat Ini: <strong>{{ $size->stock ? $size->stock->quantity : 0 }}</strong> ekor</p>
    </div>
    <a href="{{ route('admin.stocks.index') }}" class="btn btn-ghost">Kembali</a>
</div>

<div class="overflow-x-auto bg-base-100 shadow-xl rounded-box">
    <table class="table w-full">
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($movements as $movement)
            <tr>
                <td>{{ $movement->created_at->format('d M Y H:i:s') }}</td>
                <td>
                    @if($movement->type === 'in')
                        <span class="badge badge-success gap-2">Masuk</span>
                    @else
                        <span class="badge badge-error gap-2">Keluar</span>
                    @endif
                </td>
                <td>{{ $movement->quantity }}</td>
                <td>{{ $movement->note ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center py-4">Belum ada riwayat pergerakan stok.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
