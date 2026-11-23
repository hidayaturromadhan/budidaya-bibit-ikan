<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\FishSeedController;
use App\Http\Controllers\Admin\FishSeedSizeController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OngkirController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog');
Route::get('/katalog/{fishSeed}', [CatalogController::class, 'show'])->name('catalog.show');


// Ongkir API (Public so it doesn't get blocked by session expiry)
Route::get('/api/provinces', [OngkirController::class, 'getProvinces']);
Route::get('/api/cities/{id}', [OngkirController::class, 'getCities']);
Route::post('/api/check-ongkir', [OngkirController::class, 'checkCost']);

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    
    // SSO Google Routes
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Cart routes (Requires Login)
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout & Payment
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/payment/{order}', [CheckoutController::class, 'payment'])->name('checkout.payment');

    // Customer routes
    Route::middleware('role:customer')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

    // Admin routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/chart-data', [AdminDashboardController::class, 'chartData'])->name('dashboard.chart-data');

        Route::resource('fish-seeds', FishSeedController::class);
        Route::resource('fish-seed-sizes', FishSeedSizeController::class);
        Route::resource('stocks', StockController::class);
        Route::resource('orders', OrderController::class);
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    });
});

Route::post('/api/midtrans/webhook', [\App\Http\Controllers\MidtransWebhookController::class, 'handler']);
