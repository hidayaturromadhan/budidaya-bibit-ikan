@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="mb-8 mt-6">
    <h1 class="text-3xl font-extrabold text-slate-900">Keranjang Belanja</h1>
    <p class="text-slate-500 mt-2">Periksa kembali bibit ikan yang telah Anda pilih sebelum melanjutkan ke pembayaran.</p>
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

<div class="flex flex-col xl:flex-row gap-8">
    <div class="flex-grow">
        @if(count($cart) > 0)
            <div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-3xl border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="table w-full text-slate-700">
                        <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 uppercase text-xs tracking-wider">
                            <tr>
                                <th class="py-4">Produk</th>
                                <th class="py-4">Harga</th>
                                <th class="py-4">Jumlah (Ekor)</th>
                                <th class="py-4">Subtotal</th>
                                <th class="py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($cart as $id => $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="avatar">
                                            <div class="w-16 h-16 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center overflow-hidden">
                                                @if($item['image'])
                                                    <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="object-cover w-full h-full" />
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-800 text-lg">{{ $item['name'] }}</div>
                                            <div class="text-sm text-slate-500 mt-1"><span class="bg-slate-100 px-2 py-0.5 rounded-full text-xs border border-slate-200">Ukuran: {{ $item['size_label'] }}</span></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                <td class="py-4">
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['max_stock'] }}" class="input input-bordered input-sm w-24 bg-white border-slate-200 focus:border-primary rounded-lg text-center" />
                                        <button type="submit" class="btn btn-sm btn-ghost text-primary hover:bg-primary/10 rounded-lg">Update</button>
                                    </form>
                                    <div class="text-xs text-slate-400 mt-1">Maks: {{ number_format($item['max_stock'], 0, ',', '.') }}</div>
                                </td>
                                <td class="py-4 font-bold text-slate-800">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                                <td class="py-4 text-center">
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-circle btn-ghost text-red-500 hover:bg-red-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="bg-white shadow-sm border border-slate-100 rounded-3xl p-16 text-center">
                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 mb-2">Keranjang Anda Kosong</h3>
                <p class="text-slate-500 mb-8 max-w-md mx-auto">Anda belum menambahkan bibit ikan apapun ke dalam keranjang belanja. Silakan jelajahi katalog kami.</p>
                <a href="{{ route('catalog') }}" class="btn btn-primary rounded-full px-8 py-3 shadow-lg shadow-primary/30">Mulai Belanja Sekarang</a>
            </div>
        @endif
    </div>

    @if(count($cart) > 0)
    <div class="w-full xl:w-96 shrink-0">
        <div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-3xl border border-slate-100 sticky top-24">
            <div class="p-6">
                <h2 class="text-xl font-bold text-slate-800 mb-4 border-b border-slate-100 pb-4">Ringkasan Pesanan</h2>
                
                <div class="flex justify-between py-3 text-slate-600">
                    <span>Total Item:</span>
                    <span class="font-semibold text-slate-800">{{ count($cart) }} Produk</span>
                </div>
                
                <div class="flex justify-between py-4 text-xl border-t border-slate-100 mt-2">
                    <span class="font-bold text-slate-800">Total Pembayaran:</span>
                    <span class="font-black text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>

                <div class="mt-8 space-y-3">
                    <a href="{{ route('checkout.index') }}" class="btn btn-primary w-full rounded-full shadow-lg shadow-primary/30 text-lg py-3 h-auto border-0">Lanjut ke Checkout</a>
                    <a href="{{ route('catalog') }}" class="btn btn-outline w-full rounded-full border-slate-200 text-slate-600 hover:bg-slate-50 hover:border-slate-300">Lanjut Belanja</a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
