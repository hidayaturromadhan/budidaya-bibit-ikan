@extends('layouts.app')

@section('title', $fishSeed->name . ' - Gopal Fish')

@section('content')
<div class="max-w-6xl mx-auto pb-20 pt-4 px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <div class="text-xs font-semibold text-slate-500 mb-6 flex items-center gap-2">
        <a href="/" class="text-blue-600 hover:underline">Home</a>
        <span>&rsaquo;</span>
        <a href="{{ url('/') }}?category={{ urlencode($fishSeed->category) }}#katalog" class="text-blue-600 hover:underline">{{ $fishSeed->category ?? 'Kategori' }}</a>
        <span>&rsaquo;</span>
        <span class="text-slate-700 truncate max-w-[200px] sm:max-w-xs">{{ $fishSeed->name }}</span>
    </div>

    <div class="flex flex-col lg:flex-row gap-8 lg:gap-10">
        <!-- Left Column: Images -->
        <div class="w-full lg:w-[350px] shrink-0">
            <div class="w-full aspect-square bg-slate-50 rounded-xl overflow-hidden mb-4 border border-slate-200">
                @if($fishSeed->image)
                    <img src="{{ asset('storage/' . $fishSeed->image) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        <span class="text-xs uppercase tracking-wider font-semibold">No Image</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Middle Column: Product Info -->
        <div class="flex-1 min-w-0 lg:max-w-xl">
            <h1 class="text-lg sm:text-xl font-bold text-slate-900 mb-2 leading-snug">{{ $fishSeed->name }}</h1>
            
            <div class="flex items-center text-xs sm:text-sm text-slate-500 mb-4">
                <span class="text-slate-700">Terjual 10rb+</span>
                <span class="mx-2">&bull;</span>
                <svg class="h-4 w-4 text-yellow-400 mr-1 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                <span class="text-slate-700 font-semibold mr-1">4.9</span>
                <span>(1.2rb rating)</span>
            </div>

            @php $minPrice = $fishSeed->sizes->min('price'); @endphp
            <div class="text-3xl font-extrabold text-slate-900 mb-8" id="display-price">
                Rp{{ number_format($minPrice ?? 0, 0, ',', '.') }}
            </div>

            <!-- Size Selection -->
            @if($fishSeed->sizes->count() > 0)
                <div class="mb-8">
                    <h3 class="text-sm font-bold text-slate-800 mb-3">Pilih ukuran: <span class="font-normal text-slate-500" id="selected-size-label">Pilih salah satu</span></h3>
                    <div class="flex flex-wrap gap-3">
                        @foreach($fishSeed->sizes as $index => $size)
                            @php $stock = $size->stock ? $size->stock->quantity : 0; @endphp
                            <label class="cursor-pointer">
                                <input type="radio" name="size_selection" class="hidden peer" value="{{ $size->id }}" data-price="{{ $size->price }}" data-label="{{ $size->size_label }}" data-stock="{{ $stock }}" onchange="updateForm(this)" {{ $stock <= 0 ? 'disabled' : '' }}>
                                <div class="px-5 py-2 border rounded-xl text-sm font-semibold transition-all select-none {{ $stock <= 0 ? 'bg-slate-50 text-slate-400 border-slate-200 cursor-not-allowed opacity-60' : 'border-slate-300 text-slate-700 peer-checked:border-blue-600 peer-checked:bg-blue-50 peer-checked:text-blue-700 hover:border-blue-500' }}">
                                    {{ $size->size_label }}
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Tabs -->
            <div class="border-b border-slate-200 mb-6 flex gap-8">
                <button class="pb-3 border-b-2 border-blue-600 font-bold text-blue-700 text-sm">Detail Produk</button>
            </div>

            <!-- Specs -->
            <div class="text-sm text-slate-700 mb-6 space-y-3">
                <p>Kondisi: <span class="font-bold">Baru</span></p>
                <p>Min. Beli: <span class="font-bold">500 Ekor</span></p>
                <p>Kategori: <a href="{{ url('/') }}?category={{ urlencode($fishSeed->category) }}#katalog" class="text-blue-600 font-bold hover:underline">{{ $fishSeed->category ?? 'Umum' }}</a></p>
            </div>

            <div class="prose prose-sm prose-slate max-w-none text-slate-700 leading-relaxed mb-8">
                {!! nl2br(e($fishSeed->description)) !!}
            </div>
        </div>

        <!-- Right Column: Action Card -->
        <div class="w-full lg:w-[320px] shrink-0">
            <div class="border border-slate-200 rounded-xl p-4 sticky top-24 bg-white shadow-[0_4px_12px_rgb(0,0,0,0.05)]">
                <h3 class="font-bold text-slate-800 mb-4">Atur jumlah dan catatan</h3>
                
                <form action="{{ route('cart.add') }}" method="POST" id="add-to-cart-form">
                    @csrf
                    <input type="hidden" name="fish_seed_size_id" id="form_size_id" required>
                    
                    <div class="flex items-center gap-3 mb-6">
                        @if($fishSeed->image)
                            <img src="{{ asset('storage/' . $fishSeed->image) }}" class="w-10 h-10 rounded-md object-cover">
                        @else
                            <div class="w-10 h-10 rounded-md bg-slate-100 border border-slate-200"></div>
                        @endif
                        <span class="text-sm font-semibold" id="form-size-display">Pilih ukuran dulu</span>
                    </div>

                    <div class="flex items-center gap-3 mb-6">
                        <div class="flex items-center border border-slate-300 rounded-lg overflow-hidden h-8 w-24 shrink-0">
                            <button type="button" onclick="decrementQty()" class="w-8 h-full flex items-center justify-center text-slate-500 hover:bg-slate-100 hover:text-blue-600 font-bold text-lg leading-none">&minus;</button>
                            <input type="number" name="quantity" id="quantity_input" value="500" min="1" class="w-full h-full text-center border-0 focus:ring-0 text-sm font-semibold p-0 appearance-none" onchange="calculateSubtotal()">
                            <button type="button" onclick="incrementQty()" class="w-8 h-full flex items-center justify-center text-slate-500 hover:bg-slate-100 hover:text-blue-600 font-bold text-lg leading-none">&plus;</button>
                        </div>
                        <div class="text-sm text-slate-600">
                            Stok: <span class="font-bold text-slate-800" id="display-stock">-</span>
                        </div>
                    </div>

                    <div class="flex items-end justify-between mb-6">
                        <span class="text-slate-500 text-sm">Subtotal</span>
                        <div class="text-right">
                            <span class="block text-lg sm:text-xl font-extrabold text-slate-900" id="display-subtotal">Rp0</span>
                        </div>
                    </div>

                    <input type="hidden" name="action" id="form_action" value="cart">
                    
                    <button type="submit" id="btn-keranjang" disabled onclick="document.getElementById('form_action').value='cart'" class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-slate-300 disabled:text-slate-500 disabled:border-slate-300 text-white font-bold py-2.5 px-4 rounded-lg mb-2 transition-colors flex items-center justify-center gap-2 border border-blue-600">
                        <span>+ Keranjang</span>
                    </button>
                    <button type="submit" id="btn-beli-langsung" disabled onclick="document.getElementById('form_action').value='buy_now'" class="w-full bg-white hover:bg-slate-50 disabled:bg-slate-50 disabled:text-slate-400 disabled:border-slate-300 border border-blue-600 text-blue-600 font-bold py-2.5 px-4 rounded-lg transition-colors">
                        Beli Langsung
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let currentPrice = 0;
    
    function updateForm(radio) {
        const id = radio.value;
        const price = parseFloat(radio.dataset.price);
        const label = radio.dataset.label;
        const stock = parseInt(radio.dataset.stock);
        
        // Update DOM elements
        document.getElementById('selected-size-label').textContent = label;
        document.getElementById('form-size-display').textContent = label;
        document.getElementById('form_size_id').value = id;
        
        const formatter = new Intl.NumberFormat('id-ID');
        document.getElementById('display-stock').textContent = formatter.format(stock);
        document.getElementById('display-price').textContent = 'Rp' + formatter.format(price);
        
        currentPrice = price;
        calculateSubtotal();
        
        // Enable Add to cart and Beli Langsung
        document.getElementById('btn-keranjang').disabled = false;
        document.getElementById('btn-beli-langsung').disabled = false;
    }

    function calculateSubtotal() {
        const qty = parseInt(document.getElementById('quantity_input').value) || 0;
        const subtotal = currentPrice * qty;
        document.getElementById('display-subtotal').textContent = 'Rp' + new Intl.NumberFormat('id-ID').format(subtotal);
    }

    function incrementQty() {
        const input = document.getElementById('quantity_input');
        input.value = parseInt(input.value) + 1;
        calculateSubtotal();
    }

    function decrementQty() {
        const input = document.getElementById('quantity_input');
        const val = parseInt(input.value);
        if(val > 1) {
            input.value = val - 1;
            calculateSubtotal();
        }
    }
    
    // Select first available size automatically
    window.onload = function() {
        const firstAvailable = document.querySelector('input[name="size_selection"]:not([disabled])');
        if(firstAvailable) {
            firstAvailable.checked = true;
            updateForm(firstAvailable);
        }
    }
</script>
@endsection
