<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// Route halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Route dashboard, hanya untuk pengguna yang sudah login dan terverifikasi
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grup rute yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    // Rute untuk mengelola profil pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rute untuk pembayaran
    Route::post('/payment', [PaymentController::class, 'createPayment'])->name('payment.create');
});

// Grup rute untuk admin
Route::prefix('admin')->middleware('auth')->group(function () {
    // Rute untuk mengelola produk admin
    Route::get('/products', [AdminController::class, 'showProducts'])->name('admin.products.index');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('admin.products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    
    // Rute untuk laporan penjualan admin
    Route::get('/reports/sales', [AdminController::class, 'salesReport'])->name('admin.reports.sales');
});

require __DIR__.'/auth.php';
