@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="mb-8 mt-6">
    <h1 class="text-3xl font-extrabold text-slate-900">Checkout</h1>
    <p class="text-slate-500 mt-2">Lengkapi informasi pengiriman untuk menyelesaikan pesanan Anda.</p>
</div>

<div class="flex flex-col lg:flex-row gap-8">
    <div class="flex-grow">
        <div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-3xl border border-slate-100 mb-6">
            <div class="p-4 sm:p-8">
                <h2 class="text-xl font-bold text-slate-800 mb-6 border-b border-slate-100 pb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    Informasi Pengiriman
                </h2>
                <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-semibold text-slate-700">Nama Penerima</span></label>
                            <input type="text" name="recipient_name" value="{{ old('recipient_name', $lastAddress->recipient_name ?? Auth::user()->name) }}" class="input input-bordered w-full bg-slate-50 border-slate-200 focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary rounded-xl @error('recipient_name') input-error @enderror" required />
                            @error('recipient_name') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-semibold text-slate-700">Nomor Telepon / WhatsApp</span></label>
                            <input type="text" name="phone" value="{{ old('phone', $lastAddress->phone ?? '') }}" class="input input-bordered w-full bg-slate-50 border-slate-200 focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary rounded-xl @error('phone') input-error @enderror" required />
                            @error('phone') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-control w-full mb-6">
                        <label class="label"><span class="label-text font-semibold text-slate-700">Alamat Lengkap</span></label>
                        <textarea name="full_address" class="textarea textarea-bordered h-32 bg-slate-50 border-slate-200 focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary rounded-xl @error('full_address') textarea-error @enderror" placeholder="Nama Jalan, Gedung, RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten, Provinsi" required>{{ old('full_address', $lastAddress->full_address ?? '') }}</textarea>
                        @error('full_address') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-control w-full mb-8">
                        <label class="label"><span class="label-text font-semibold text-slate-700">Kode Pos (Opsional)</span></label>
                        <input type="text" name="postal_code" value="{{ old('postal_code', $lastAddress->postal_code ?? '') }}" class="input input-bordered w-full md:w-1/2 bg-slate-50 border-slate-200 focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary rounded-xl @error('postal_code') input-error @enderror" />
                        @error('postal_code') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" /></svg>
                        Metode Pengiriman
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-semibold text-slate-700">Provinsi Tujuan</span></label>
                            <select id="province" name="province_id" class="select select-bordered w-full bg-slate-50 border-slate-200 focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary rounded-xl" required>
                                <option value="" disabled selected>Memuat provinsi...</option>
                            </select>
                        </div>
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-semibold text-slate-700">Kota/Kabupaten Tujuan</span></label>
                            <select id="city" name="city_id" class="select select-bordered w-full bg-slate-50 border-slate-200 focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary rounded-xl" required disabled>
                                <option value="" disabled selected>Pilih Provinsi dulu</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-semibold text-slate-700">Kurir</span></label>
                            <select id="courier" name="expedition_name" class="select select-bordered w-full bg-slate-50 border-slate-200 focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary rounded-xl" required disabled>
                                <option value="" disabled selected>Pilih Kurir</option>
                                <option value="jne">JNE</option>
                                <option value="pos">POS Indonesia</option>
                                <option value="tiki">TIKI</option>
                            </select>
                        </div>
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-semibold text-slate-700">Layanan Pengiriman</span></label>
                            <select id="service" name="shipping_service" class="select select-bordered w-full bg-slate-50 border-slate-200 focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary rounded-xl" required disabled>
                                <option value="" disabled selected>Pilih Kurir dulu</option>
                            </select>
                        </div>
                    </div>

                    <input type="hidden" name="shipping_cost" id="shipping_cost_input" value="0">
                    <input type="hidden" id="total_weight" value="1000"> <!-- Default 1kg -->
                </form>
            </div>
        </div>
    </div>

    <div class="w-full lg:w-96 shrink-0">
        <div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-3xl border border-slate-100 sticky top-24">
            <div class="p-4 sm:p-6">
                <h2 class="text-xl font-bold text-slate-800 mb-4 border-b border-slate-100 pb-4">Ringkasan Pesanan</h2>
                
                <div class="max-h-80 overflow-y-auto mb-4 border-b border-slate-100 pb-4 pr-2 space-y-4">
                    @foreach($cart as $item)
                        <div class="flex gap-3 text-sm">
                            <div class="w-12 h-12 rounded-lg bg-slate-100 overflow-hidden shrink-0 border border-slate-200">
                                @if($item['image'])
                                    <img src="{{ asset('storage/' . $item['image']) }}" class="w-full h-full object-cover" />
                                @else
                                    <div class="w-full h-full flex justify-center items-center text-[10px] text-slate-400">IMG</div>
                                @endif
                            </div>
                            <div class="flex-grow">
                                <div class="font-bold text-slate-800 leading-tight">{{ $item['name'] }}</div>
                                <div class="text-slate-500 text-xs mt-0.5">Ukuran: {{ $item['size_label'] }}</div>
                                <div class="text-slate-500 text-xs">{{ $item['quantity'] }} ekor x Rp {{ number_format($item['price'], 0, ',', '.') }}</div>
                            </div>
                            <div class="font-bold text-slate-800 text-right shrink-0">
                                Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="flex justify-between py-2 text-sm font-bold">
                    <span class="text-slate-600">Total Produk:</span>
                    <span class="text-slate-800" id="product_total" data-total="{{ $total }}">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-2 text-sm font-bold border-b border-slate-100 pb-4">
                    <span class="text-slate-600">Ongkos Kirim:</span>
                    <span class="text-slate-800" id="shipping_cost_display">Rp 0</span>
                </div>
                <div class="flex justify-between py-2 text-lg font-bold mt-2">
                    <span class="text-slate-600">Total Tagihan:</span>
                    <span class="text-primary text-2xl" id="grand_total">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>

                <div class="mt-8">
                    <button type="submit" form="checkout-form" class="btn btn-primary w-full rounded-full shadow-lg shadow-primary/30 text-lg py-3 h-auto border-0 flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Buat Pesanan & Bayar
                    </button>
                    <p class="text-center text-xs text-slate-400 mt-4 flex items-center justify-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        Pembayaran dijamin aman (Dummy QRIS)
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const provinceSelect = document.getElementById('province');
        const citySelect = document.getElementById('city');
        const courierSelect = document.getElementById('courier');
        const serviceSelect = document.getElementById('service');
        
        const productTotal = parseInt(document.getElementById('product_total').dataset.total);
        const weight = document.getElementById('total_weight').value;
        const shippingCostInput = document.getElementById('shipping_cost_input');
        const shippingCostDisplay = document.getElementById('shipping_cost_display');
        const grandTotalDisplay = document.getElementById('grand_total');

        const formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 });

        // Load Provinces
        console.log("Mulai memuat provinsi...");
        fetch('/api/provinces?_t=' + new Date().getTime())
            .then(response => {
                console.log("Response diterima: ", response.status);
                if (!response.ok) {
                    throw new Error("HTTP error " + response.status);
                }
                return response.json();
            })
            .then(data => {
                console.log("Data provinsi: ", data);
                if(data.error || !Array.isArray(data)) {
                    provinceSelect.innerHTML = `<option value="" disabled selected>Gagal memuat API: ${data.error || 'Server error'}</option>`;
                    return;
                }
                provinceSelect.innerHTML = '<option value="" disabled selected>Pilih Provinsi</option>';
                data.forEach(province => {
                    provinceSelect.innerHTML += `<option value="${province.province_id}">${province.province}</option>`;
                });
                console.log("Sukses memasukkan data ke dropdown.");
            })
            .catch(error => {
                console.error("Fetch error: ", error);
                provinceSelect.innerHTML = `<option value="" disabled selected>Koneksi terputus: ${error.message}</option>`;
                alert("Gagal memuat provinsi: " + error.message);
            });

        // Load Cities on Province change
        provinceSelect.addEventListener('change', function() {
            citySelect.innerHTML = '<option value="" disabled selected>Memuat kota...</option>';
            citySelect.disabled = true;
            
            fetch(`/api/cities/${this.value}?_t=` + new Date().getTime())
                .then(response => response.json())
                .then(data => {
                    if(data.error || !Array.isArray(data)) {
                        citySelect.innerHTML = `<option value="" disabled selected>Gagal memuat API: ${data.error || 'Server error'}</option>`;
                        return;
                    }
                    citySelect.innerHTML = '<option value="" disabled selected>Pilih Kota/Kabupaten</option>';
                    data.forEach(city => {
                        citySelect.innerHTML += `<option value="${city.city_id}">${city.type} ${city.city_name}</option>`;
                    });
                    citySelect.disabled = false;
                })
                .catch(error => {
                    citySelect.innerHTML = '<option value="" disabled selected>Koneksi terputus</option>';
                });
        });

        // Enable Courier on City change
        citySelect.addEventListener('change', function() {
            courierSelect.disabled = false;
            courierSelect.value = '';
            serviceSelect.innerHTML = '<option value="" disabled selected>Pilih Kurir dulu</option>';
            serviceSelect.disabled = true;
            resetShipping();
        });

        // Load Services on Courier change
        courierSelect.addEventListener('change', function() {
            if (!citySelect.value) return;

            serviceSelect.innerHTML = '<option value="" disabled selected>Menghitung ongkir...</option>';
            serviceSelect.disabled = true;
            resetShipping();

            fetch('/api/check-ongkir', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    destination: citySelect.value,
                    weight: weight,
                    courier: this.value
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.length === 0) {
                    serviceSelect.innerHTML = '<option value="" disabled selected>Layanan tidak tersedia</option>';
                    return;
                }

                serviceSelect.innerHTML = '<option value="" disabled selected>Pilih Layanan</option>';
                data.forEach(service => {
                    const cost = service.cost[0].value;
                    const etd = service.cost[0].etd ? ` (${service.cost[0].etd} HARI)` : '';
                    serviceSelect.innerHTML += `<option value="${service.service}" data-cost="${cost}">${service.service} - ${formatter.format(cost)} ${etd}</option>`;
                });
                serviceSelect.disabled = false;
            })
            .catch(error => {
                serviceSelect.innerHTML = '<option value="" disabled selected>Gagal menghitung ongkir</option>';
            });
        });

        // Update Total on Service change
        serviceSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const cost = parseInt(selectedOption.dataset.cost);
            
            shippingCostInput.value = cost;
            shippingCostDisplay.textContent = formatter.format(cost);
            grandTotalDisplay.textContent = formatter.format(productTotal + cost);
        });

        function resetShipping() {
            shippingCostInput.value = 0;
            shippingCostDisplay.textContent = 'Rp 0';
            grandTotalDisplay.textContent = formatter.format(productTotal);
        }
    });
</script>
@endpush
@endsection
