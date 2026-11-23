<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dashboard pelanggan Gopal Fish. Pantau pesanan Anda dengan mudah.">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Dashboard Pelanggan') - Gopal Fish</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 min-h-screen text-slate-800">

<div class="drawer lg:drawer-open">
    <input id="customer-drawer" type="checkbox" class="drawer-toggle" />
    
    <!-- Main Content -->
    <div class="drawer-content flex flex-col min-h-screen">
        
        <!-- Top Navbar -->
        <div class="navbar bg-white shadow-sm sticky top-0 z-40 border-b border-slate-100 px-4">
            <div class="flex-none lg:hidden">
                <label for="customer-drawer" class="btn btn-square btn-ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-6 h-6 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </label>
            </div> 
            <div class="flex-1 lg:hidden">
                <a href="{{ route('dashboard') }}" class="font-bold text-lg text-slate-800">Akun Saya</a>
            </div>
            <div class="flex-1 hidden lg:flex justify-start px-4">
                <h1 class="text-xl font-bold text-slate-800">@yield('title')</h1>
            </div>
            <div class="flex-none gap-2">
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                        <div class="w-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </label>
                    <ul tabindex="0" class="mt-3 z-[1] p-2 shadow-lg menu menu-sm dropdown-content bg-white rounded-box w-52 border border-slate-100">
                        <li class="menu-title px-4 py-2">
                            <span class="block text-xs font-semibold text-slate-400">Masuk sebagai</span>
                            <span class="block text-sm font-bold text-slate-700">{{ Auth::user()->name }}</span>
                        </li>
                        <div class="divider my-1"></div>
                        <li><a href="{{ route('catalog') }}" class="text-slate-600"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg> Belanja Lagi</a></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="inline block w-full text-left p-0">
                                @csrf
                                <button type="submit" class="text-red-500 w-full text-left px-4 py-2 hover:bg-red-50 rounded-lg">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-y-auto">
            @yield('content')
        </main>
        
    </div> 
    
    <!-- Sidebar / Drawer Side -->
    <div class="drawer-side z-50">
        <label for="customer-drawer" class="drawer-overlay"></label> 
        <div class="w-72 min-h-screen bg-white text-slate-700 flex flex-col border-r border-slate-200 shadow-sm">
            <!-- Sidebar Header -->
            <div class="h-16 flex items-center px-6 bg-slate-50 font-black text-xl tracking-wider text-slate-800 border-b border-slate-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                Akun Saya
            </div>
            
            <!-- Sidebar Menu -->
            <ul class="menu p-4 w-full flex-1 space-y-1">
                <li class="menu-title text-slate-400 text-xs font-bold uppercase tracking-wider mb-2 mt-2">Menu Utama</li>
                
                <li>
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-primary/10 text-primary font-bold' : 'text-slate-600 hover:bg-slate-50' }} rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                        Riwayat Pesanan
                    </a>
                </li>

                <li class="menu-title text-slate-400 text-xs font-bold uppercase tracking-wider mb-2 mt-6">Aktivitas</li>
                
                <li>
                    <a href="{{ route('catalog') }}" class="text-slate-600 hover:bg-slate-50 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                        Katalog Ikan
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('cart.index') }}" class="text-slate-600 hover:bg-slate-50 rounded-xl flex justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            Keranjang Belanja
                        </div>
                        @php $cartCount = count(session('cart', [])); @endphp
                        @if($cartCount > 0)
                            <span class="badge badge-sm badge-primary">{{ $cartCount }}</span>
                        @endif
                    </a>
                </li>
                
            </ul>

            <!-- Sidebar Footer -->
            <div class="p-4 text-xs text-slate-500 text-center border-t border-slate-100">
                &copy; {{ date('Y') }} Sistem Budidaya
            </div>
        </div>
    </div>
</div>

</body>
</html>
