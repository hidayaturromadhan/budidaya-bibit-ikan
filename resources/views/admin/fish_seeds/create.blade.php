@extends('layouts.admin')

@section('title', 'Tambah Bibit Ikan')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold">Tambah Bibit Ikan Baru</h1>
</div>

<div class="card bg-white shadow-sm border border-slate-100 max-w-4xl rounded-3xl overflow-hidden">
    <div class="card-body p-8">
        <form action="{{ route('admin.fish-seeds.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Kolom Kiri: Informasi Dasar -->
                <div class="space-y-5">
                    <h3 class="text-lg font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4">Informasi Dasar</h3>
                    
                    <div class="form-control w-full">
                        <label class="label"><span class="label-text font-semibold text-slate-600">Nama Bibit Ikan <span class="text-red-500">*</span></span></label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Ikan Nila Merah" class="input input-bordered w-full bg-slate-50 focus:bg-white focus:border-primary @error('name') input-error @enderror" required />
                        @error('name') <span class="text-error text-sm mt-1 flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg> {{ $message }}</span> @enderror
                    </div>

                    <div class="form-control w-full">
                        <label class="label"><span class="label-text font-semibold text-slate-600">Kategori</span></label>
                        <input type="text" name="category" value="{{ old('category') }}" placeholder="Contoh: Ikan Nila" class="input input-bordered w-full bg-slate-50 focus:bg-white focus:border-primary @error('category') input-error @enderror" />
                        @error('category') <span class="text-error text-sm mt-1 flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg> {{ $message }}</span> @enderror
                    </div>

                    <div class="form-control w-full">
                        <label class="label"><span class="label-text font-semibold text-slate-600">Deskripsi</span></label>
                        <textarea name="description" placeholder="Jelaskan keunggulan bibit ini..." class="textarea textarea-bordered h-32 bg-slate-50 focus:bg-white focus:border-primary @error('description') textarea-error @enderror">{{ old('description') }}</textarea>
                        @error('description') <span class="text-error text-sm mt-1 flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg> {{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Kolom Kanan: Media & Pengaturan -->
                <div class="space-y-5">
                    <h3 class="text-lg font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4">Media & Status</h3>

                    <div class="form-control w-full">
                        <label class="label"><span class="label-text font-semibold text-slate-600">Foto (Opsional)</span></label>
                        
                        <!-- Preview Image Container -->
                        <div id="imagePreviewContainer" class="hidden w-full h-48 rounded-2xl bg-slate-100 border-2 border-dashed border-slate-300 mb-3 overflow-hidden relative group">
                            <img id="imagePreview" src="" alt="Preview" class="object-cover w-full h-full" />
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <span class="text-white text-sm font-semibold">Klik tombol di bawah untuk mengganti</span>
                            </div>
                        </div>

                        <input type="file" name="image" id="imageInput" class="file-input file-input-bordered w-full bg-slate-50 @error('image') file-input-error @enderror" accept="image/*" />
                        <span class="text-xs text-slate-400 mt-2 block">Format yang didukung: JPG, PNG, WEBP. Maks 2MB.</span>
                        @error('image') <span class="text-error text-sm mt-1 flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg> {{ $message }}</span> @enderror
                    </div>

                    <div class="form-control w-full mt-6 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        <label class="cursor-pointer label justify-start gap-4">
                            <input type="checkbox" name="is_active" class="toggle toggle-primary" checked="checked" value="1" />
                            <div>
                                <span class="label-text font-bold text-slate-700 block">Status Aktif</span>
                                <span class="text-xs text-slate-500">Tampilkan bibit ini di katalog pelanggan</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 mt-10 pt-6 border-t border-slate-100">
                <button type="submit" class="btn btn-primary rounded-full px-8">Simpan Bibit</button>
                <a href="{{ route('admin.fish-seeds.index') }}" class="btn btn-ghost rounded-full px-8">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('imageInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('imagePreviewContainer');
        const previewImage = document.getElementById('imagePreview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        } else {
            previewImage.src = '';
            previewContainer.classList.add('hidden');
        }
    });
</script>
@endsection
