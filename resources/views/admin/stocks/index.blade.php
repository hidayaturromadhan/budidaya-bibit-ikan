@extends('layouts.admin')

@section('title', 'Kelola Stok Bibit')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Data Stok Bibit Ikan</h1>
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
                <th>Bibit Ikan</th>
                <th>Ukuran</th>
                <th>Stok Tersedia</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sizes as $size)
            <tr>
                <td>{{ $size->fishSeed->name }}</td>
                <td>{{ $size->size_label }}</td>
                <td>
                    @php $qty = $size->stock ? $size->stock->quantity : 0; @endphp
                    @if($qty <= 0)
                        <span class="badge badge-error gap-2">Habis</span>
                    @elseif($qty < 50)
                        <span class="badge badge-warning gap-2">{{ $qty }} Ekor (Menipis)</span>
                    @else
                        <span class="badge badge-success gap-2">{{ $qty }} Ekor</span>
                    @endif
                </td>
                <td>
                    <div class="join">
                        <a href="{{ route('admin.stocks.edit', $size->id) }}" class="btn btn-sm btn-primary join-item">Update Stok</a>
                        <a href="{{ route('admin.stocks.show', $size->id) }}" class="btn btn-sm btn-info join-item">Riwayat</a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center py-4">Belum ada data ukuran bibit. Tambahkan ukuran terlebih dahulu.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
