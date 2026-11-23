@extends('layouts.app')

@section('title', 'Masuk - Budidaya Bibit Ikan')

@section('content')
<div class="flex items-center justify-center min-h-[85vh] py-10">
    <div class="w-full max-w-[440px] px-4 sm:px-0">
        <div class="bg-white shadow-[0_20px_60px_rgb(0,0,0,0.07)] rounded-[2.5rem] border border-slate-100 overflow-hidden relative">
            <!-- Decorative Top Gradient -->
            <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-blue-500 to-indigo-600"></div>
            
            <div class="p-8 sm:p-10">
                <div class="text-center mb-8">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 overflow-hidden border-4 border-white shadow-xl bg-slate-50">
                        <img src="{{ asset('logo.jpeg') }}" alt="Logo" class="w-full h-full object-cover" onerror="this.src='https://ui-avatars.com/api/?name=Budidaya+Bibit&background=0D8ABC&color=fff'">
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mb-1">Selamat Datang!</h2>
                    <p class="text-slate-500 text-sm">Masuk dengan Google SSO atau akun demo Anda.</p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 text-red-700 p-4 rounded-2xl text-sm mb-6 border border-red-100">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Google SSO Button -->
                <div>
                    <a href="{{ route('auth.google') }}" class="btn bg-white hover:bg-slate-50 text-slate-700 w-full rounded-2xl shadow-sm text-base font-bold py-3.5 h-auto border border-slate-200 transition-all hover:scale-[1.01] flex items-center justify-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                        Lanjutkan dengan Google
                    </a>
                </div>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs uppercase">
                        <span class="bg-white px-3 text-slate-400 font-semibold tracking-wider">Atau Masuk dengan Email</span>
                    </div>
                </div>

                <!-- Manual Login Form -->
                <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5" for="email">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="admin@admin.com" 
                            class="input input-bordered w-full rounded-2xl bg-slate-50 focus:bg-white text-slate-800 border-slate-200 focus:border-primary focus:ring-2 focus:ring-primary/20 h-12 text-sm transition-all">
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider" for="password">Password</label>
                        </div>
                        <input type="password" name="password" id="password" required placeholder="••••••••" 
                            class="input input-bordered w-full rounded-2xl bg-slate-50 focus:bg-white text-slate-800 border-slate-200 focus:border-primary focus:ring-2 focus:ring-primary/20 h-12 text-sm transition-all">
                    </div>

                    <div class="flex items-center justify-between text-xs pt-1">
                        <label class="flex items-center gap-2 cursor-pointer text-slate-600">
                            <input type="checkbox" name="remember" class="checkbox checkbox-primary checkbox-xs rounded">
                            <span>Ingat saya</span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary w-full rounded-2xl text-white font-bold h-12 shadow-lg shadow-blue-500/25 border-0 hover:bg-blue-700 transition-all text-base mt-2">
                        Masuk
                    </button>
                </form>

                <!-- Demo Account Fast Fill Box -->
                <div class="mt-6 pt-5 border-t border-slate-100 bg-slate-50/80 -mx-4 -mb-4 p-5 rounded-b-[2rem]">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400 text-center mb-3">⚡ Akses Cepat Demo Akun</p>
                    <div class="grid grid-cols-2 gap-2">
                        <button type="button" onclick="fillCredentials('admin@admin.com', 'password')" class="btn btn-sm btn-outline border-slate-300 hover:bg-primary hover:border-primary rounded-xl text-xs font-medium normal-case flex items-center justify-center gap-1.5 h-10">
                            <span>👑</span>
                            <div class="text-left">
                                <span class="font-bold block leading-none">Admin</span>
                                <span class="text-[10px] text-slate-400">admin@admin.com</span>
                            </div>
                        </button>
                        <button type="button" onclick="fillCredentials('user@user.com', 'password')" class="btn btn-sm btn-outline border-slate-300 hover:bg-primary hover:border-primary rounded-xl text-xs font-medium normal-case flex items-center justify-center gap-1.5 h-10">
                            <span>🛒</span>
                            <div class="text-left">
                                <span class="font-bold block leading-none">Pelanggan</span>
                                <span class="text-[10px] text-slate-400">user@user.com</span>
                            </div>
                        </button>
                    </div>
                    <p class="text-[11px] text-slate-400 text-center mt-2.5">Password default: <code class="bg-white px-1 py-0.5 rounded border border-slate-200 font-mono text-slate-600">password</code></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function fillCredentials(email, password) {
    document.getElementById('email').value = email;
    document.getElementById('password').value = password;
}
</script>
@endsection
