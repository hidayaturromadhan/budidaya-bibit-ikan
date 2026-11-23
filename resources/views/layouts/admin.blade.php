<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Admin Panel') - Gopal Fish</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 min-h-screen text-slate-800">

<div class="drawer lg:drawer-open">
    <input id="admin-drawer" type="checkbox" class="drawer-toggle" />
    
    <!-- Main Content -->
    <div class="drawer-content flex flex-col min-h-screen">
        
        <!-- Top Navbar -->
        <div class="navbar bg-white shadow-sm sticky top-0 z-40 border-b border-slate-100 px-4">
            <div class="flex-none lg:hidden">
                <label for="admin-drawer" class="btn btn-square btn-ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-6 h-6 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </label>
            </div> 
            <div class="flex-1 lg:hidden">
                <a href="{{ route('admin.dashboard') }}" class="font-bold text-lg text-slate-800">Admin Panel</a>
            </div>
            <div class="flex-1 hidden lg:flex justify-start px-4">
                <h1 class="text-xl font-bold text-slate-800">@yield('title')</h1>
            </div>
            <div class="flex-none gap-2">
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                        <div class="w-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </label>
                    <ul tabindex="0" class="mt-3 z-[1] p-2 shadow-lg menu menu-sm dropdown-content bg-white rounded-box w-52 border border-slate-100">
                        <li class="menu-title px-4 py-2">
                            <span class="block text-xs font-semibold text-slate-400">Masuk sebagai</span>
                            <span class="block text-sm font-bold text-slate-700">{{ Auth::user()->name }}</span>
                        </li>
                        <div class="divider my-1"></div>
                        <li><a href="{{ route('catalog') }}" class="text-slate-600"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg> Kembali ke Web</a></li>
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
        <label for="admin-drawer" class="drawer-overlay"></label> 
        <div class="w-72 min-h-screen bg-slate-900 text-slate-300 flex flex-col">
            <!-- Sidebar Header -->
            <div class="h-16 flex items-center px-6 bg-slate-950 font-black text-xl tracking-wider text-white border-b border-slate-800 shadow-md">
                <img src="{{ asset('logo.jpeg') }}" alt="Logo" class="h-10 w-auto rounded mr-3 shadow-sm border border-slate-700" />
                <span class="hidden sm:inline-block truncate">Gopal Fish</span>
            </div>
            
            <!-- Sidebar Menu -->
            <ul class="menu p-4 w-full text-base-content flex-1 space-y-1">
                <li class="menu-title text-slate-500 text-xs font-bold uppercase tracking-wider mb-2 mt-4">Menu Utama</li>
                
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white hover:bg-primary-focus' : 'text-slate-300 hover:text-white hover:bg-slate-800' }} rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                        Dashboard
                    </a>
                </li>
                
                <li class="menu-title text-slate-500 text-xs font-bold uppercase tracking-wider mb-2 mt-6">Data Master</li>
                
                <li>
                    <a href="{{ route('admin.fish-seeds.index') }}" class="{{ request()->routeIs('admin.fish-seeds.*') ? 'bg-primary text-white hover:bg-primary-focus' : 'text-slate-300 hover:text-white hover:bg-slate-800' }} rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                        Bibit Ikan
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('admin.fish-seed-sizes.index') }}" class="{{ request()->routeIs('admin.fish-seed-sizes.*') ? 'bg-primary text-white hover:bg-primary-focus' : 'text-slate-300 hover:text-white hover:bg-slate-800' }} rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                        Ukuran & Harga
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('admin.stocks.index') }}" class="{{ request()->routeIs('admin.stocks.*') ? 'bg-primary text-white hover:bg-primary-focus' : 'text-slate-300 hover:text-white hover:bg-slate-800' }} rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                        Manajemen Stok
                    </a>
                </li>

                <li class="menu-title text-slate-500 text-xs font-bold uppercase tracking-wider mb-2 mt-6">Transaksi & Laporan</li>
                
                <li>
                    <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'bg-primary text-white hover:bg-primary-focus' : 'text-slate-300 hover:text-white hover:bg-slate-800' }} rounded-xl flex justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                            Pesanan Masuk
                        </div>
                        @php
                            $pendingOrders = \App\Models\Order::where('status', 'pending')->orWhere('status', 'diproses')->count();
                        @endphp
                        @if($pendingOrders > 0)
                            <span class="badge badge-sm badge-primary">{{ $pendingOrders }}</span>
                        @endif
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.*') ? 'bg-primary text-white hover:bg-primary-focus' : 'text-slate-300 hover:text-white hover:bg-slate-800' }} rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        Laporan Penjualan
                    </a>
                </li>
            </ul>

            <!-- Sidebar Footer -->
            <div class="p-4 text-xs text-slate-600 text-center border-t border-slate-800">
                &copy; {{ date('Y') }} Sistem Budidaya
            </div>
        </div>
    </div>
</div>

</body>
</html>
