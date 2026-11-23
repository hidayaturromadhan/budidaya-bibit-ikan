@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="mb-8 mt-6">
    <h1 class="text-3xl font-extrabold text-slate-900">Dashboard Administrator</h1>
    <p class="text-slate-500 mt-2">Selamat datang, <span class="font-bold text-slate-700">{{ Auth::user()->name }}</span>. Kelola data utama sistem dari sini.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <!-- Quick Stats Cards (Dummy for visual) -->
    <div class="bg-white shadow-[0_4px_20px_rgb(0,0,0,0.03)] rounded-3xl border border-slate-100 p-6 flex items-center gap-4">
        <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
        </div>
        <div>
            <div class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Total Pesanan</div>
            <div class="text-2xl font-black text-slate-800" id="stat-total-orders">...</div>
        </div>
    </div>
    
    <div class="bg-white shadow-[0_4px_20px_rgb(0,0,0,0.03)] rounded-3xl border border-slate-100 p-6 flex items-center gap-4">
        <div class="w-14 h-14 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </div>
        <div>
            <div class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Pendapatan</div>
            <div class="text-2xl font-black text-slate-800" id="stat-total-revenue">...</div>
        </div>
    </div>

    <div class="bg-white shadow-[0_4px_20px_rgb(0,0,0,0.03)] rounded-3xl border border-slate-100 p-6 flex items-center gap-4">
        <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
        </div>
        <div>
            <div class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Pelanggan</div>
            <div class="text-2xl font-black text-slate-800" id="stat-active-customers">...</div>
        </div>
    </div>
</div>

<div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-3xl border border-slate-100 p-6 mb-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" /></svg>
            Grafik Pendapatan (7 Hari Terakhir)
        </h2>
        <div class="text-xs font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-full flex items-center gap-1">
            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> Live Update
        </div>
    </div>
    <div class="w-full h-80 relative">
        <canvas id="revenueChart"></canvas>
    </div>
</div>

<div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-3xl border border-slate-100 overflow-hidden">
    <div class="p-8">
        <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
            Menu Manajemen Utama
        </h2>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            <a href="{{ route('admin.fish-seeds.index') }}" class="flex flex-col items-center justify-center p-6 bg-slate-50 rounded-2xl border border-slate-200 hover:border-primary hover:bg-primary/5 transition-all group">
                <div class="w-12 h-12 bg-white rounded-full shadow-sm flex items-center justify-center text-primary group-hover:scale-110 transition-transform mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                </div>
                <span class="font-semibold text-slate-700 text-center text-sm">Kelola Bibit Ikan</span>
            </a>
            
            <a href="{{ route('admin.fish-seed-sizes.index') }}" class="flex flex-col items-center justify-center p-6 bg-slate-50 rounded-2xl border border-slate-200 hover:border-blue-500 hover:bg-blue-50 transition-all group">
                <div class="w-12 h-12 bg-white rounded-full shadow-sm flex items-center justify-center text-blue-500 group-hover:scale-110 transition-transform mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                </div>
                <span class="font-semibold text-slate-700 text-center text-sm">Ukuran & Harga</span>
            </a>
            
            <a href="{{ route('admin.stocks.index') }}" class="flex flex-col items-center justify-center p-6 bg-slate-50 rounded-2xl border border-slate-200 hover:border-emerald-500 hover:bg-emerald-50 transition-all group">
                <div class="w-12 h-12 bg-white rounded-full shadow-sm flex items-center justify-center text-emerald-500 group-hover:scale-110 transition-transform mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                </div>
                <span class="font-semibold text-slate-700 text-center text-sm">Kelola Stok</span>
            </a>
            
            <a href="{{ route('admin.orders.index') }}" class="flex flex-col items-center justify-center p-6 bg-slate-50 rounded-2xl border border-slate-200 hover:border-indigo-500 hover:bg-indigo-50 transition-all group">
                <div class="w-12 h-12 bg-white rounded-full shadow-sm flex items-center justify-center text-indigo-500 group-hover:scale-110 transition-transform mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                </div>
                <span class="font-semibold text-slate-700 text-center text-sm">Pesanan</span>
            </a>
            
            <a href="{{ route('admin.reports.index') }}" class="flex flex-col items-center justify-center p-6 bg-slate-50 rounded-2xl border border-slate-200 hover:border-amber-500 hover:bg-amber-50 transition-all group">
                <div class="w-12 h-12 bg-white rounded-full shadow-sm flex items-center justify-center text-amber-500 group-hover:scale-110 transition-transform mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                </div>
                <span class="font-semibold text-slate-700 text-center text-sm">Laporan</span>
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let chartInstance = null;

        function fetchDashboardData() {
            fetch('{{ route("admin.dashboard.chart-data") }}')
                .then(response => response.json())
                .then(data => {
                    // Update Quick Stats
                    document.getElementById('stat-total-orders').innerText = data.stats.totalOrders;
                    document.getElementById('stat-total-revenue').innerText = data.stats.totalRevenue;
                    document.getElementById('stat-active-customers').innerText = data.stats.activeCustomers;

                    // Update Chart
                    if (chartInstance) {
                        chartInstance.data.labels = data.chart.labels;
                        chartInstance.data.datasets[0].data = data.chart.data;
                        chartInstance.update();
                    } else {
                        const ctx = document.getElementById('revenueChart').getContext('2d');
                        chartInstance = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: data.chart.labels,
                                datasets: [{
                                    label: 'Pendapatan (Rp)',
                                    data: data.chart.data,
                                    borderColor: '#3b82f6',
                                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                    borderWidth: 3,
                                    tension: 0.4,
                                    fill: true,
                                    pointBackgroundColor: '#ffffff',
                                    pointBorderColor: '#3b82f6',
                                    pointBorderWidth: 2,
                                    pointRadius: 4,
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { display: false }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            callback: function(value) {
                                                return 'Rp ' + value.toLocaleString('id-ID');
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    }
                })
                .catch(error => console.error('Error fetching dashboard data:', error));
        }

        // Initial fetch
        fetchDashboardData();

        // Polling every 30 seconds
        setInterval(fetchDashboardData, 30000);
    });
</script>
@endsection
