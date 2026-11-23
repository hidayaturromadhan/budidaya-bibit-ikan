@extends('layouts.app')

@section('title', 'Pusat Bibit Ikan Air Tawar Berkualitas')

@section('content')

<!-- 1. HERO SECTION -->
<div class="relative w-[100vw] left-[50%] right-[50%] -ml-[50vw] -mr-[50vw] bg-gradient-to-br from-blue-50/50 via-white to-blue-50/30 overflow-hidden mb-20 flex items-center min-h-[calc(100vh-5rem)]">
    <!-- Dekorasi Soft Blobs -->
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-blue-100/50 blur-3xl opacity-60"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 rounded-full bg-cyan-100/50 blur-3xl opacity-60"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="text-center lg:text-left">
                <div class="inline-flex items-center gap-2 py-2 px-4 rounded-full bg-white/80 backdrop-blur-md text-blue-600 text-sm font-bold mb-6 shadow-sm border border-white/50">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                    </span>
                    #1 Pusat Bibit Ikan Terpercaya
                </div>
                <h1 class="text-4xl tracking-tight font-extrabold text-slate-900 sm:text-5xl md:text-6xl leading-[1.15]">
                    Solusi Terbaik Untuk
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">Panen Ikan Maksimal</span>
                </h1>
                <p class="mt-6 text-base text-slate-500 sm:text-lg md:text-xl max-w-xl mx-auto lg:mx-0 leading-relaxed">
                    Kami menyediakan benih ikan air tawar sehat, lincah, dan kebal penyakit. Mulai perjalanan budidaya Anda dengan bibit unggulan langsung dari ahlinya.
                </p>
                <div class="mt-10 flex flex-col sm:flex-row justify-center lg:justify-start gap-4">
                    <a href="#katalog" class="flex items-center justify-center px-8 py-4 text-base font-bold rounded-full text-white bg-blue-600 hover:bg-blue-700 transition-all duration-300 shadow-[0_8px_20px_rgba(37,99,235,0.25)] hover:shadow-[0_8px_25px_rgba(37,99,235,0.4)] hover:-translate-y-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                        Lihat Katalog Produk
                    </a>
                </div>
            </div>
            
            <div class="relative hidden lg:block">
                <!-- Main Image with Soft Shadow -->
                <div class="relative rounded-[2rem] overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.1)] border-8 border-white bg-white transform rotate-2 hover:rotate-0 transition-transform duration-500">
                    <img src="https://images.unsplash.com/photo-1524704654690-b56c05c78a00?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Budidaya Ikan" class="object-cover w-full h-[400px]" />
                </div>
                <!-- Floating Element -->
                <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-2xl shadow-xl border border-slate-100 flex items-center gap-4 animate-bounce" style="animation-duration: 3s;">
                    <div class="bg-green-100 p-3 rounded-full text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-slate-800">100% Tersertifikasi</div>
                        <div class="text-xs text-slate-500">Bebas penyakit</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 1.5 CALL TO ACTION (CTA) -->
<div class="mb-20 bg-gradient-to-r from-blue-600 to-indigo-700 rounded-[2.5rem] shadow-[0_20px_50px_rgba(37,99,235,0.2)] overflow-hidden relative">
    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    <!-- Soft Decorative Circles -->
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 rounded-full bg-white/10 blur-3xl"></div>
    
    <div class="px-8 py-12 sm:px-16 sm:py-16 lg:flex lg:items-center lg:justify-between relative z-10">
        <div>
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl leading-tight">
                <span class="block">Siap memulai budidaya?</span>
                <span class="block text-blue-200 mt-2">Kami pandu hingga panen.</span>
            </h2>
            <p class="mt-4 text-lg leading-relaxed text-blue-100 max-w-xl">Dapatkan harga spesial untuk pengambilan partai besar. Jangan ragu untuk menghubungi tim ahli kami jika Anda butuh rekomendasi bibit yang tepat.</p>
        </div>
        <div class="mt-10 flex flex-col sm:flex-row lg:mt-0 lg:flex-shrink-0 gap-4">
            <a href="#katalog" class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-base font-bold rounded-full text-blue-700 bg-white hover:bg-slate-50 hover:shadow-lg transition-all duration-300">
                Mulai Belanja
            </a>
            <a href="https://wa.me/6282297804400" target="_blank" class="inline-flex items-center justify-center px-8 py-4 border border-blue-400 text-base font-bold rounded-full text-white bg-transparent hover:bg-blue-800/50 transition-colors duration-300">
                Hubungi WhatsApp
            </a>
        </div>
    </div>
</div>



@if (session('success'))
    <div class="alert alert-success bg-green-50 border border-green-200 text-green-800 shadow-sm mb-6 rounded-2xl">
        <span>{{ session('success') }}</span>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-error bg-red-50 border border-red-200 text-red-800 shadow-sm mb-6 rounded-2xl">
        <span>{{ session('error') }}</span>
    </div>
@endif

<!-- 4. CATALOG SECTION -->
<div id="katalog" class="pt-4 sm:pt-8 scroll-mt-24">
    <div class="flex flex-col sm:flex-row items-center justify-between mb-4 sm:mb-6 gap-4">
        <div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Bibit Unggulan Pilihan</h2>
            <p class="text-slate-500 mt-1">Produk benih ikan terbaik dan terlaris dari Gopal Fish.</p>
        </div>
        <a href="{{ route('catalog') }}" class="text-sm font-bold text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 px-5 py-2.5 rounded-full transition-colors hidden sm:inline-flex items-center">
            Lihat Semua Katalog
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        </a>
    </div>


    <div class="flex flex-wrap justify-center gap-3 sm:gap-4">
        @forelse($fishSeeds as $seed)
        <a href="{{ route('catalog.show', $seed) }}" class="w-[calc(50%-0.375rem)] sm:w-[calc(33.333%-0.66rem)] md:w-[calc(25%-0.75rem)] lg:w-[calc(20%-0.8rem)] xl:w-[calc(16.666%-0.85rem)] bg-white shadow-sm hover:shadow-md border border-slate-200 transition-all duration-300 rounded-xl overflow-hidden flex flex-col group relative">
            <!-- Image Area -->
            <div class="relative w-full aspect-square overflow-hidden bg-slate-50 shrink-0">
                @if($seed->image)
                    <img src="{{ asset('storage/' . $seed->image) }}" alt="{{ $seed->name }}" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500" />
                @else
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                @endif
                
                <!-- Discount/Stock Badge -->
                @php $totalStock = $seed->sizes->sum(function($size) { return $size->stock ? $size->stock->quantity : 0; }); @endphp
                @if($totalStock == 0)
                    <div class="absolute top-0 left-0 bg-slate-800 text-white text-[10px] font-bold px-2 py-0.5 rounded-br-lg shadow-sm">
                        Habis
                    </div>
                @elseif($totalStock > 0 && $totalStock <= 500)
                    <div class="absolute top-0 left-0 bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-br-lg shadow-sm animate-pulse">
                        Sisa {{ $totalStock }}
                    </div>
                @else
                    <div class="absolute top-0 left-0 bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-br-lg shadow-sm">
                        Bisa COD
                    </div>
                @endif
            </div>
            
            <!-- Content Area -->
            <div class="p-2 sm:p-3 flex flex-col flex-grow">
                <h3 class="text-xs sm:text-sm text-slate-800 line-clamp-2 leading-snug mb-1">{{ $seed->name }}</h3>
                
                @php
                    $minPrice = $seed->sizes->min('price');
                @endphp
                <div class="mt-auto pt-1">
                    <span class="text-sm sm:text-base font-extrabold text-slate-900 block mb-1">
                        Rp{{ number_format($minPrice ?? 0, 0, ',', '.') }}
                    </span>
                    
                    <div class="flex items-center text-[10px] sm:text-xs text-slate-500 mb-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-yellow-400 mr-1 shrink-0 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <span class="mr-1">4.9</span>
                        <span class="mx-1">|</span>
                        <span class="truncate">10rb+ terjual</span>
                    </div>
                    
                    <div class="flex items-center text-[10px] text-slate-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span class="truncate">{{ $seed->category ?? 'Umum' }}</span>
                    </div>
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-full py-24 bg-slate-50/50 rounded-3xl border-2 border-dashed border-slate-200 shadow-sm text-center">
            <div class="mx-auto h-24 w-24 bg-white rounded-full flex items-center justify-center shadow-sm border border-slate-100 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-slate-800">Katalog Belum Tersedia</h3>
            <p class="text-slate-500 mt-3 max-w-md mx-auto text-lg">Kami sedang mempersiapkan bibit ikan terbaik. Silakan periksa kembali beberapa saat lagi.</p>
        </div>
        @endforelse
    </div>
</div>

<!-- 2. KEUNGGULAN (Why Choose Us) -->
<div class="w-[100vw] left-[50%] right-[50%] -ml-[50vw] -mr-[50vw] py-16 bg-white mb-20 relative mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="text-center mb-16 relative z-10">
            <h2 class="text-sm font-extrabold text-blue-600 uppercase tracking-widest mb-3">Mengapa Memilih Kami?</h2>
        <p class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
            Kualitas Unggul, Hasil Memuaskan
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 relative z-10">
        <!-- Keunggulan 1 -->
        <div class="text-center p-6 rounded-3xl hover:bg-slate-50 transition-colors duration-300">
            <div class="flex items-center justify-center h-20 w-20 rounded-full bg-blue-50 text-blue-500 mx-auto mb-6 shadow-inner border border-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" /></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-3">Tersertifikasi</h3>
            <p class="text-slate-500 text-sm leading-relaxed">Semua bibit ikan melewati proses karantina dan dipastikan bebas dari jamur maupun parasit.</p>
        </div>
        <!-- Keunggulan 2 -->
        <div class="text-center p-6 rounded-3xl hover:bg-slate-50 transition-colors duration-300">
            <div class="flex items-center justify-center h-20 w-20 rounded-full bg-emerald-50 text-emerald-500 mx-auto mb-6 shadow-inner border border-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-3">Harga Petani</h3>
            <p class="text-slate-500 text-sm leading-relaxed">Mendapatkan harga langsung dari pembudidaya pertama. Lebih ekonomis untuk partai besar.</p>
        </div>
        <!-- Keunggulan 3 -->
        <div class="text-center p-6 rounded-3xl hover:bg-slate-50 transition-colors duration-300">
            <div class="flex items-center justify-center h-20 w-20 rounded-full bg-indigo-50 text-indigo-500 mx-auto mb-6 shadow-inner border border-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-3">Pengiriman Aman</h3>
            <p class="text-slate-500 text-sm leading-relaxed">Menggunakan oksigen murni ganda dan *packing* tebal untuk menjamin ikan selamat sampai tujuan.</p>
        </div>
        <!-- Keunggulan 4 -->
        <div class="text-center p-6 rounded-3xl hover:bg-slate-50 transition-colors duration-300">
            <div class="flex items-center justify-center h-20 w-20 rounded-full bg-amber-50 text-amber-500 mx-auto mb-6 shadow-inner border border-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" /></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-3">Konsultasi Gratis</h3>
            <p class="text-slate-500 text-sm leading-relaxed">Tim ahli kami siap mendampingi Anda terkait manajemen pakan, air, dan penanganan penyakit.</p>
        </div>
    </div>
    </div>
</div>

<!-- 4.5 LOCATION SECTION -->
<div class="pt-20 scroll-mt-24" id="lokasi">
    <div class="text-center mb-10">
        <h2 class="text-3xl font-extrabold text-slate-900">Lokasi Kami</h2>
        <p class="text-slate-500 mt-2 max-w-2xl mx-auto">Kunjungi kolam pembibitan kami secara langsung untuk melihat kualitas benih ikan yang kami tawarkan.</p>
    </div>
    
    <div class="flex flex-col lg:flex-row gap-10 lg:gap-16 items-center">
        <div class="w-full lg:w-3/5 h-[350px] sm:h-[450px] rounded-3xl overflow-hidden relative bg-slate-100 shadow-lg border border-slate-100">
            <iframe src="https://www.google.com/maps?q=1.4643693,102.1296663&output=embed" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="absolute inset-0 w-full h-full"></iframe>
        </div>
        <div class="w-full lg:w-2/5 flex flex-col justify-center">
            <div class="bg-blue-50 w-14 h-14 rounded-2xl flex items-center justify-center text-blue-600 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <h3 class="text-2xl font-extrabold tracking-tighter text-blue-600 lowercase mb-3 flex items-center justify-center sm:justify-start" style="font-family: 'Nunito', 'Plus Jakarta Sans', sans-serif;">
                gopal
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 ml-0.5 mt-0.5">
                    <path d="M6.5 12c.94-3.46 4.94-6 8.5-6 3.56 0 6.06 2.54 7 6-.94 3.47-3.44 6-7 6s-7.56-2.53-8.5-6Z"/>
                    <circle cx="17" cy="11.5" r="1.5" fill="currentColor" stroke="none" />
                    <path d="M2 16.3c1.78-.97 3-2.92 3-5.3s-1.22-4.33-3-5.3"/>
                    <path d="M6 12H2"/>
                </svg>
            </h3>
            <p class="text-slate-500 mb-8 leading-relaxed text-sm">
                Temukan lokasi pembibitan kami dengan mudah menggunakan panduan arah dari Google Maps. Kami siap melayani kunjungan Anda di jam operasional.
            </p>
            <a href="https://maps.app.goo.gl/9wwjXLtf8G41THM69" target="_blank" class="btn btn-primary rounded-full shadow-lg shadow-primary/20 hover:shadow-primary/40 font-bold text-sm h-12 w-full sm:w-auto px-8 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" /></svg>
                Buka di Google Maps
            </a>
        </div>
    </div>
</div>

@endsection
