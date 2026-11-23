@extends('layouts.admin')

@section('title', 'Update Stok Bibit')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold">Update Stok: {{ $size->fishSeed->name }} ({{ $size->size_label }})</h1>
    <p class="text-gray-500 mt-2">Stok Saat Ini: <strong>{{ $size->stock ? $size->stock->quantity : 0 }}</strong> ekor</p>
</div>

<div class="card bg-base-100 shadow-xl max-w-2xl">
    <div class="card-body">
        <form action="{{ route('admin.stocks.update', $size->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-control w-full mb-4">
                <label class="label"><span class="label-text">Jenis Pergerakan</span></label>
                <select name="type" class="select select-bordered w-full @error('type') select-error @enderror" required>
                    <option value="in" {{ old('type') == 'in' ? 'selected' : '' }}>Stok Masuk (Tambah)</option>
                    <option value="out" {{ old('type') == 'out' ? 'selected' : '' }}>Stok Keluar (Kurang)</option>
                </select>
                @error('type') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="form-control w-full mb-4">
                <label class="label"><span class="label-text">Jumlah (Ekor)</span></label>
                <input type="number" name="quantity" value="{{ old('quantity') }}" class="input input-bordered w-full @error('quantity') input-error @enderror" min="1" required />
                @error('quantity') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
            </div>
            
            <div class="form-control w-full mb-6">
                <label class="label"><span class="label-text">Keterangan / Catatan</span></label>
                <input type="text" name="note" value="{{ old('note') }}" class="input input-bordered w-full @error('note') input-error @enderror" placeholder="Misal: Penambahan dari supplier A" />
                @error('note') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="btn btn-primary">Simpan Update Stok</button>
                <a href="{{ route('admin.stocks.index') }}" class="btn btn-ghost">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
