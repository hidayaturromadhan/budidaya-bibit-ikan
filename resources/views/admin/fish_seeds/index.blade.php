@extends('layouts.admin')

@section('title', 'Kelola Bibit Ikan')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Data Bibit Ikan</h1>
    <a href="{{ route('admin.fish-seeds.create') }}" class="btn btn-primary">Tambah Bibit Baru</a>
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
                <th class="bg-slate-50 text-slate-500 font-bold tracking-wider uppercase text-xs rounded-tl-xl">ID</th>
                <th class="bg-slate-50 text-slate-500 font-bold tracking-wider uppercase text-xs">Foto</th>
                <th class="bg-slate-50 text-slate-500 font-bold tracking-wider uppercase text-xs">Nama</th>
                <th class="bg-slate-50 text-slate-500 font-bold tracking-wider uppercase text-xs">Kategori</th>
                <th class="bg-slate-50 text-slate-500 font-bold tracking-wider uppercase text-xs">Status</th>
                <th class="bg-slate-50 text-slate-500 font-bold tracking-wider uppercase text-xs rounded-tr-xl">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($fishSeeds as $seed)
            <tr>
                <td class="font-semibold text-slate-700">{{ $seed->id }}</td>
                <td>
                    @if ($seed->image)
                        <div class="avatar">
                            <div class="w-14 h-14 rounded-xl shadow-sm border border-slate-100">
                                <img src="{{ asset('storage/' . $seed->image) }}" alt="{{ $seed->name }}" class="object-cover" />
                            </div>
                        </div>
                    @else
                        <div class="w-14 h-14 rounded-xl bg-slate-100 flex items-center justify-center border border-slate-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                </td>
                <td class="font-bold text-slate-800">{{ $seed->name }}</td>
                <td>
                    <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-full text-xs font-semibold border border-blue-100">{{ $seed->category ?: 'Umum' }}</span>
                </td>
                <td>
                    @if($seed->is_active)
                        <span class="badge badge-success bg-green-100 border-green-200 text-green-700 font-bold gap-1 px-3 py-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                            Aktif
                        </span>
                    @else
                        <span class="badge badge-error bg-red-100 border-red-200 text-red-700 font-bold gap-1 px-3 py-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                            Nonaktif
                        </span>
                    @endif
                </td>
                <td>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.fish-seeds.edit', $seed) }}" class="btn btn-sm btn-circle btn-ghost text-blue-500 hover:bg-blue-50" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </a>
                        <form action="{{ route('admin.fish-seeds.destroy', $seed) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus bibit ini? Data ukuran dan stok terkait mungkin akan terdampak.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-circle btn-ghost text-red-500 hover:bg-red-50" title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-12">
                    <div class="flex flex-col items-center justify-center">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4 border border-slate-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-700">Belum ada data bibit ikan</h3>
                        <p class="text-slate-500 text-sm mt-1 mb-4">Mulai dengan menambahkan bibit ikan pertama Anda ke dalam sistem.</p>
                        <a href="{{ route('admin.fish-seeds.create') }}" class="btn btn-primary btn-sm">Tambah Bibit Baru</a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
