@extends('layouts.admin')

@section('title', 'Tambah Ukuran Bibit')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold">Tambah Ukuran Bibit Baru</h1>
</div>

<div class="card bg-base-100 shadow-xl max-w-2xl">
    <div class="card-body">
        <form action="{{ route('admin.fish-seed-sizes.store') }}" method="POST">
            @csrf
            
            <div class="form-control w-full mb-4">
                <label class="label"><span class="label-text">Pilih Bibit Ikan</span></label>
                <select name="fish_seed_id" class="select select-bordered w-full @error('fish_seed_id') select-error @enderror" required>
                    <option disabled selected>-- Pilih Bibit --</option>
                    @foreach($fishSeeds as $seed)
                        <option value="{{ $seed->id }}" {{ old('fish_seed_id') == $seed->id ? 'selected' : '' }}>{{ $seed->name }}</option>
                    @endforeach
                </select>
                @error('fish_seed_id') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="form-control w-full mb-4">
                <label class="label"><span class="label-text">Label Ukuran (mis. 2-3 cm)</span></label>
                <input type="text" name="size_label" value="{{ old('size_label') }}" class="input input-bordered w-full @error('size_label') input-error @enderror" required />
                @error('size_label') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="form-control w-full mb-6">
                <label class="label"><span class="label-text">Harga per Ekor (Rp)</span></label>
                <input type="number" name="price" value="{{ old('price') }}" class="input input-bordered w-full @error('price') input-error @enderror" min="0" required />
                @error('price') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.fish-seed-sizes.index') }}" class="btn btn-ghost">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
