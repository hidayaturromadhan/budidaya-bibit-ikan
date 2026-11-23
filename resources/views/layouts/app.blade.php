<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pusat penjualan bibit ikan air tawar unggulan. Kami menyediakan bibit ikan berkualitas, sehat, tersertifikasi, dengan harga petani untuk kesuksesan budidaya Anda.">
    <meta name="keywords" content="bibit ikan, jual bibit ikan, ikan nila, ikan lele, gurame, patin, ikan mas, gopal fish, gopal fish bibit">
    <meta name="author" content="Gopal Fish">
    <meta name="robots" content="index, follow">
    
    <!-- OpenGraph & Twitter Cards -->
    <meta property="og:title" content="@yield('title', 'Beranda') - Gopal Fish">
    <meta property="og:description" content="Pusat penjualan bibit ikan air tawar unggulan dengan kualitas terbaik dan harga kompetitif dari Gopal Fish.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('storage/default-og-image.jpg') }}">
    <meta name="twitter:card" content="summary_large_image">
    
    <title>@yield('title', 'Beranda') - Gopal Fish</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('logo.jpeg') }}">
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 min-h-screen flex flex-col text-slate-800 overflow-x-hidden">
    <!-- Navbar -->
    <div class="bg-white shadow-sm sticky top-0 z-50 border-b border-slate-100">
        <div class="navbar max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full gap-2 sm:gap-4">
            <!-- Logo -->
            <div class="flex-none">
                <a href="/" class="btn btn-ghost px-2 hover:bg-transparent flex items-center">
                    <img src="{{ asset('logo.jpeg') }}" alt="Logo Gopal Fish" class="h-8 sm:h-10 w-auto rounded-lg shadow-sm" />
                    <span class="ml-2 text-2xl hidden md:flex items-center font-extrabold tracking-tighter text-blue-600 lowercase" style="font-family: 'Nunito', 'Plus Jakarta Sans', sans-serif;">
                        gopal
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-7 h-7 ml-1 mt-0.5">
                            <path d="M6.5 12c.94-3.46 4.94-6 8.5-6 3.56 0 6.06 2.54 7 6-.94 3.47-3.44 6-7 6s-7.56-2.53-8.5-6Z"/>
                            <circle cx="17" cy="11.5" r="1.5" fill="currentColor" stroke="none" />
                            <path d="M2 16.3c1.78-.97 3-2.92 3-5.3s-1.22-4.33-3-5.3"/>
                            <path d="M6 12H2"/>
                        </svg>
                    </span>
                </a>
            </div>
            
            <!-- Search & Category (Desktop & Mobile) -->
            <div class="flex-1 w-full max-w-2xl px-2">
                <form action="{{ route('catalog') }}" method="GET" class="w-full flex items-center bg-slate-50 border border-slate-200 focus-within:bg-white focus-within:border-blue-300 focus-within:ring-4 focus-within:ring-blue-50 rounded-full h-10 sm:h-12 transition-all">
                    <!-- Dropdown Category -->
                    <div class="dropdown lg:dropdown-bottom dropdown-start h-full">
                        <div tabindex="0" role="button" class="h-full flex items-center justify-center px-3 sm:px-5 border-r border-slate-200 text-xs sm:text-sm font-bold text-slate-600 hover:text-slate-900 transition-colors bg-transparent rounded-l-full cursor-pointer">
                            <span class="hidden sm:inline-block">{{ request('category') && request('category') !== 'all' ? request('category') : 'Kategori' }}</span>
                            <span class="sm:hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 hidden sm:block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                        <ul tabindex="0" class="dropdown-content z-[99] menu p-2 shadow-lg bg-white rounded-2xl w-52 border border-slate-100 mt-2 origin-top animate-fade-in-down">
                            <li><a href="{{ route('catalog') }}?category=all" class="{{ request('category', 'all') === 'all' ? 'active bg-blue-50 text-blue-700 font-bold' : 'font-semibold text-slate-600' }}">Semua Kategori</a></li>
                            @if(isset($categories))
                                @foreach($categories as $cat)
                                    <li><a href="{{ route('catalog') }}?category={{ urlencode($cat) }}" class="{{ request('category') === $cat ? 'active bg-blue-50 text-blue-700 font-bold' : 'font-semibold text-slate-600' }}">{{ $cat }}</a></li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    
                    <!-- Search Input -->
                    <div class="relative flex-1 h-full">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                        <!-- Security: The request('search') value is securely HTML-encoded by Blade -->
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari benih ikan..." class="w-full h-full pl-9 sm:pl-10 pr-4 bg-transparent border-none focus:outline-none focus:ring-0 text-xs sm:text-sm font-semibold rounded-r-full" />
                        <!-- Keep category selected on search -->
                        @if(request('category') && request('category') !== 'all')
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                    </div>
                    <button type="submit" class="hidden">Search</button>
                </form>
            </div>
        
        <!-- Mobile Menu (Dropdown) -->
        <div class="flex-none lg:hidden ml-auto">
            <div class="dropdown dropdown-end">
                <label tabindex="0" class="btn btn-ghost btn-circle">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /></svg>
                </label>
                <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                    <li>
                        <a href="{{ route('cart.index') }}" class="flex items-center gap-2">
                            <div class="indicator">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                @php $cartCount = count(session('cart', [])); @endphp
                                @if($cartCount > 0)
                                    <span class="badge badge-sm badge-primary indicator-item">{{ $cartCount }}</span>
                                @endif
                            </div>
                            Keranjang
                        </a>
                    </li>
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <li><a href="{{ route('admin.dashboard') }}" class="font-bold text-primary">Ke Panel Admin →</a></li>
                        @else
                            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        @endif
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left text-red-500">Logout</button>
                            </form>
                        </li>
                    @else
                        <li><a href="{{ route('login') }}">Login</a></li>
                    @endauth
                </ul>
            </div>
        </div>

        <!-- Desktop Menu -->
        <div class="flex-none hidden lg:flex ml-auto">
            <ul class="menu menu-horizontal px-1 items-center gap-1">
                <li>
                    <a href="{{ route('cart.index') }}" class="btn btn-ghost btn-circle" title="Keranjang">
                        <div class="indicator">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            @php $cartCount = count(session('cart', [])); @endphp
                            @if($cartCount > 0)
                                <span class="badge badge-sm badge-primary indicator-item">{{ $cartCount }}</span>
                            @endif
                        </div>
                    </a>
                </li>
                @auth
                    @if(Auth::user()->role === 'admin')
                        <li><a href="{{ route('admin.dashboard') }}" class="font-bold text-primary">Ke Panel Admin →</a></li>
                    @else
                        <li><a href="{{ route('dashboard') }}" class="rounded-full">Dashboard</a></li>
                    @endif
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-ghost text-red-500 rounded-full">Logout</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}" class="rounded-full">Login</a></li>
                @endauth
            </ul>
        </div>
    </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full mt-6 mb-auto flex-1">
        @yield('content')
    </main>
    <footer class="bg-white border-t border-slate-100 pt-16 pb-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-2">
                    <a href="/" class="text-3xl font-extrabold tracking-tighter text-blue-600 lowercase flex items-center gap-3 mb-4" style="font-family: 'Nunito', 'Plus Jakarta Sans', sans-serif;">
                        <img src="{{ asset('logo.jpeg') }}" alt="Logo" class="h-12 w-auto rounded-xl shadow-md border border-slate-100" />
                        gopal
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-9 h-9 ml-0.5 mt-0.5">
                            <path d="M6.5 12c.94-3.46 4.94-6 8.5-6 3.56 0 6.06 2.54 7 6-.94 3.47-3.44 6-7 6s-7.56-2.53-8.5-6Z"/>
                            <circle cx="17" cy="11.5" r="1.5" fill="currentColor" stroke="none" />
                            <path d="M2 16.3c1.78-.97 3-2.92 3-5.3s-1.22-4.33-3-5.3"/>
                            <path d="M6 12H2"/>
                        </svg>
                    </a>
                    <p class="text-slate-500 text-sm leading-relaxed max-w-sm mb-6">
                        Pusat pembibitan ikan air tawar terpercaya. Kami berdedikasi menyediakan benih ikan unggul bersertifikat untuk mendukung ketahanan pangan dan kesuksesan peternak lokal.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-slate-400 hover:text-primary transition-colors">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                        </a>
                        <a href="https://instagram.com/faldi_kesuma22" target="_blank" class="text-slate-400 hover:text-primary transition-colors">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-sm font-bold text-slate-900 tracking-wider uppercase mb-4">Navigasi</h3>
                    <ul class="space-y-3 text-sm text-slate-500">
                        <li><a href="/" class="hover:text-primary transition-colors">Beranda</a></li>
                        <li><a href="/#katalog" class="hover:text-primary transition-colors">Katalog Ikan</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-primary transition-colors">Keranjang</a></li>
                        <li><a href="{{ route('dashboard') }}" class="hover:text-primary transition-colors">Lacak Pesanan</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-sm font-bold text-slate-900 tracking-wider uppercase mb-4">Kontak & Bantuan</h3>
                    <ul class="space-y-3 text-sm text-slate-500">
                        <li class="flex items-start gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <span>Senggoro, Bengkalis, Riau, Sumatera, 28714, Indonesia</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                            <span>+62 822-9780-4400</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-slate-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-slate-400">
                <p>&copy; {{ date('Y') }} Gopal Fish. Seluruh Hak Cipta Dilindungi.</p>
                <div class="flex gap-4">
                    <a href="#" class="hover:text-slate-600">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-slate-600">Kebijakan Privasi</a>
                </div>
            </div>
        </div>
    </footer>
    @stack('scripts')
</body>
</html>
