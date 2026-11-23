@extends('layouts.admin')

@section('title', 'Kelola Ukuran Bibit')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Data Ukuran Bibit Ikan</h1>
    <a href="{{ route('admin.fish-seed-sizes.create') }}" class="btn btn-primary">Tambah Ukuran Baru</a>
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
                <th>Bibit Ikan</th>
                <th>Ukuran</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sizes as $size)
            <tr>
                <td>{{ $size->id }}</td>
                <td>{{ $size->fishSeed->name }}</td>
                <td>{{ $size->size_label }}</td>
                <td>Rp {{ number_format($size->price, 0, ',', '.') }}</td>
                <td>
                    <div class="join">
                        <a href="{{ route('admin.fish-seed-sizes.edit', $size) }}" class="btn btn-sm btn-info join-item">Edit</a>
                        <form action="{{ route('admin.fish-seed-sizes.destroy', $size) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-error join-item">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-4">Belum ada data ukuran bibit.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
