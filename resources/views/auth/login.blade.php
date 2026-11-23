@extends('layouts.app')

@section('title', 'Masuk - Gopal Fish')

@section('content')
<div class="flex items-center justify-center min-h-[80vh] py-12">
    <div class="w-full max-w-[420px] px-4 sm:px-0">
        <div class="bg-white shadow-[0_20px_60px_rgb(0,0,0,0.06)] rounded-[2.5rem] border border-slate-100 overflow-hidden relative">
            <!-- Decorative Top Gradient -->
            <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-blue-400 to-blue-600"></div>
            
            <div class="p-8 sm:p-10">
                <div class="text-center mb-10">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 overflow-hidden border-4 border-white shadow-xl bg-white">
                        <img src="{{ asset('logo.jpeg') }}" alt="Gopal Fish Logo" class="w-full h-full object-cover">
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mb-2">Selamat Datang!</h2>
                    <p class="text-slate-500 text-sm">Silakan masuk untuk melanjutkan aktivitas Anda.</p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 text-red-700 p-4 rounded-xl text-sm mb-6 border border-red-100">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="pt-4 space-y-4">
                    <a href="{{ route('auth.google') }}" class="btn bg-white hover:bg-slate-50 text-slate-700 w-full rounded-full shadow-lg shadow-slate-200/50 text-base font-bold py-3.5 h-auto border border-slate-200 transition-all hover:scale-[1.02] flex items-center justify-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                            <path d="M1 1h22v22H1z" fill="none"/>
                        </svg>
                        Lanjutkan dengan Google
                    </a>
                </div>

                <div class="mt-8 text-center text-sm text-slate-500">
                    Sistem akan otomatis membuat akun jika Anda belum terdaftar.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
