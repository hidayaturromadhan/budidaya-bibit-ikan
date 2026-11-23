@extends('layouts.app')

@section('title', 'Katalog Benih Ikan - Gopal Fish')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar Filter (Desktop) -->
        <div class="w-full lg:w-64 shrink-0">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sticky top-24">
                <h2 class="text-lg font-extrabold text-slate-900 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                    Filter Katalog
                </h2>
                
                <form action="{{ route('catalog') }}" method="GET" id="filter-form">
                    <!-- Preserve search query -->
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    <div class="mb-6">
                        <h3 class="font-bold text-slate-800 mb-3 text-sm">Kategori Ikan</h3>
                        <div class="space-y-2">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="radio" name="category" value="all" onchange="this.form.submit()" class="radio radio-primary radio-sm" {{ request('category', 'all') === 'all' ? 'checked' : '' }}>
                                <span class="text-sm font-semibold {{ request('category', 'all') === 'all' ? 'text-blue-700' : 'text-slate-600 group-hover:text-blue-600' }}">Semua Kategori</span>
                            </label>
                            
                            @foreach($categories as $cat)
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" name="category" value="{{ $cat }}" onchange="this.form.submit()" class="radio radio-primary radio-sm" {{ request('category') === $cat ? 'checked' : '' }}>
                                    <span class="text-sm font-semibold {{ request('category') === $cat ? 'text-blue-700' : 'text-slate-600 group-hover:text-blue-600' }}">{{ $cat }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 min-w-0">
            <!-- Header Section -->
            <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-black text-slate-900 mb-2">
                        @if(request('search'))
                            Hasil pencarian: <span class="text-blue-600">"{{ request('search') }}"</span>
                        @elseif(request('category') && request('category') !== 'all')
                            Kategori: <span class="text-blue-600">{{ request('category') }}</span>
                        @else
                            Semua Katalog Bibit Ikan
                        @endif
                    </h1>
                    <p class="text-slate-500 font-medium">Menampilkan {{ $fishSeeds->firstItem() ?? 0 }} - {{ $fishSeeds->lastItem() ?? 0 }} dari total {{ $fishSeeds->total() }} produk.</p>
                </div>
            </div>

            <!-- Product Grid -->
            @if($fishSeeds->count() > 0)
                <div class="flex flex-wrap gap-3 sm:gap-4 mb-10">
                    @foreach($fishSeeds as $seed)
                    @php
                        $totalStock = $seed->sizes->sum(function($s) { return $s->stock ? $s->stock->quantity : 0; });
                        $isOutOfStock = $totalStock <= 0;
                        $minPrice = $seed->sizes->min('price');
                    @endphp
                    <a href="{{ route('catalog.show', $seed) }}" class="w-[calc(50%-0.375rem)] sm:w-[calc(33.333%-0.66rem)] md:w-[calc(33.333%-0.66rem)] lg:w-[calc(25%-0.75rem)] xl:w-[calc(20%-0.8rem)] bg-white shadow-sm hover:shadow-md border border-slate-200 transition-all duration-300 rounded-xl overflow-hidden flex flex-col group relative" @if($isOutOfStock) style="opacity: 0.75; background-color: #f8fafc;" @endif>
                        <!-- Image Area -->
                        <div class="relative w-full aspect-square overflow-hidden bg-slate-50 shrink-0">
                            @if($seed->image)
                                <img src="{{ asset('storage/' . $seed->image) }}" alt="{{ $seed->name }}" class="object-cover w-full h-full {{ $isOutOfStock ? 'grayscale-[60%]' : 'group-hover:scale-105' }} transition-transform duration-500" />
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                            @endif
                            
                            <!-- Centered Out of Stock Overlay -->
                            @if($isOutOfStock)
                                <div class="absolute inset-0 flex items-center justify-center z-10" style="background-color: rgba(15, 23, 42, 0.6); backdrop-filter: blur(1px);">
                                    <span class="text-xs sm:text-sm font-black px-4 py-1.5 rounded-full shadow-xl uppercase tracking-wider" style="background-color: #dc2626; color: #ffffff; border: 2px solid #ffffff; letter-spacing: 0.08em; box-shadow: 0 4px 14px rgba(0,0,0,0.4);">
                                        HABIS
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Content Area -->
                        <div class="p-2 sm:p-3 flex flex-col flex-1">
                            <h3 class="text-sm font-bold text-slate-800 line-clamp-2 leading-snug mb-1 group-hover:text-blue-600 transition-colors">{{ $seed->name }}</h3>
                            
                            <div class="mt-auto pt-1">
                                <p class="text-base font-black block mb-1.5" style="color: #2563eb;">
                                    Rp{{ number_format($minPrice ?? 0, 0, ',', '.') }}
                                </p>
                                
                                <div class="flex items-center justify-between text-[10px] sm:text-xs mb-1 gap-1">
                                    <span class="text-slate-500 truncate">{{ number_format($seed->total_sold, 0, ',', '.') }} terjual</span>
                                    @if($isOutOfStock)
                                        <span class="inline-flex items-center text-[10px] font-bold px-2 py-0.5 rounded shadow-xs shrink-0" style="background-color: #dc2626; color: #ffffff;">Habis</span>
                                    @else
                                        <span class="inline-flex items-center text-[10px] font-bold px-2 py-0.5 rounded shadow-xs shrink-0" style="background-color: #059669; color: #ffffff;">Ready: {{ number_format($totalStock, 0, ',', '.') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-8 flex justify-center">
                    {{ $fishSeeds->links() }}
                </div>
            @else
                <div class="bg-white rounded-3xl p-12 text-center border border-slate-100 shadow-sm flex flex-col items-center">
                    <div class="h-24 w-24 bg-slate-50 rounded-full flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Bibit Ikan Tidak Ditemukan</h3>
                    <p class="text-slate-500 max-w-md mx-auto">Kami tidak dapat menemukan produk yang sesuai dengan pencarian atau filter Anda saat ini. Silakan coba kata kunci lain.</p>
                    <a href="{{ route('catalog') }}" class="btn btn-primary mt-6 rounded-full">Lihat Semua Katalog</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
