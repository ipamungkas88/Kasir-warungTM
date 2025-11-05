<?php

use Illuminate\Support\Facades\Route;

// Redirect root to login
Route::get('/', function () {
    return redirect('/login');
});

// Authentication routes
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Owner only routes
    Route::middleware(['role:owner'])->group(function () {
        Route::get('/owner/dashboard', [App\Http\Controllers\OwnerController::class, 'dashboard'])->name('owner.dashboard');
        
        // Manajemen Menu
        Route::get('/owner/manajemen-menu', [App\Http\Controllers\OwnerController::class, 'manajemenMenu'])->name('owner.manajemen-menu');
        Route::post('/owner/menu', [App\Http\Controllers\OwnerController::class, 'storeMenu'])->name('owner.store-menu');
        Route::put('/owner/menu/{menu}', [App\Http\Controllers\OwnerController::class, 'updateMenu'])->name('owner.update-menu');
        Route::delete('/owner/menu/{menu}', [App\Http\Controllers\OwnerController::class, 'deleteMenu'])->name('owner.delete-menu');
        
        // Laporan Penjualan
        Route::get('/owner/laporan-penjualan', [App\Http\Controllers\OwnerController::class, 'laporanPenjualan'])->name('owner.laporan-penjualan');
        
        // Riwayat Transaksi
        Route::get('/owner/riwayat-transaksi', [App\Http\Controllers\OwnerController::class, 'riwayatTransaksi'])->name('owner.riwayat-transaksi');
        Route::get('/owner/transaksi/{id}/detail', [App\Http\Controllers\OwnerController::class, 'transactionDetail'])->name('owner.transaction-detail');
        
        // Manajemen Pengguna
        Route::get('/owner/manajemen-pengguna', [App\Http\Controllers\OwnerController::class, 'manajemenPengguna'])->name('owner.manajemen-pengguna');
        Route::post('/owner/users', [App\Http\Controllers\OwnerController::class, 'storeUser'])->name('owner.users.store');
        Route::post('/owner/users/update', [App\Http\Controllers\OwnerController::class, 'updateUser'])->name('owner.users.update');
        Route::post('/owner/users/delete', [App\Http\Controllers\OwnerController::class, 'deleteUser'])->name('owner.users.delete');
    });

    // Kasir only routes
    Route::middleware(['role:kasir'])->group(function () {
        Route::get('/kasir/dashboard', [App\Http\Controllers\KasirController::class, 'dashboard'])->name('kasir.dashboard');
        Route::get('/kasir/transaksi', [App\Http\Controllers\KasirController::class, 'transaksi'])->name('kasir.transaksi');
        Route::post('/kasir/transaksi', [App\Http\Controllers\KasirController::class, 'storeTransaction'])->name('kasir.store-transaction');
        Route::post('/kasir/create-payment-token', [App\Http\Controllers\KasirController::class, 'createPaymentToken'])->name('kasir.create-payment-token');
        Route::get('/kasir/check-payment-status/{orderId}', [App\Http\Controllers\KasirController::class, 'checkPaymentStatus'])->name('kasir.check-payment-status');
        Route::get('/kasir/riwayat-transaksi', [App\Http\Controllers\KasirController::class, 'riwayatTransaksi'])->name('kasir.riwayat-transaksi');
        Route::get('/kasir/transaksi/{id}/detail', [App\Http\Controllers\KasirController::class, 'transactionDetail'])->name('kasir.transaction-detail');
    });
});

// Midtrans Callback (without CSRF protection)
Route::post('/midtrans-callback', [App\Http\Controllers\KasirController::class, 'midtransCallback'])->name('midtrans-callback');
