<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\CatalogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Customer\PesananController;
use App\Http\Controllers\Admin\PemesananController;

// Rute Halaman Utama (Katalog) bisa diakses siapa saja, termasuk pengguna yang belum login
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/kontak', [HomeController::class, 'contact'])->name('contact');
Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/katalog/{item}', [CatalogController::class, 'show'])->name('catalog.show');
Route::get('/katalog/{item}/cek-stok', [CatalogController::class, 'checkStock'])->name('catalog.check-stock');

Route::middleware('auth')->group(function () {
    Route::get('/pesanan/{pemesanan}', [PesananController::class, 'show'])->name('pesanan.show');
    Route::post('/pesanan/{pemesanan}/kondisi-baik', [PesananController::class, 'kondisiBaik'])->name('pesanan.kondisi-baik');
    Route::get('/pesanan/{pemesanan}/laporan-kerusakan', [PesananController::class, 'createKerusakan'])->name('pesanan.laporan-kerusakan.create');
    Route::post('/pesanan/{pemesanan}/laporan-kerusakan', [PesananController::class, 'storeKerusakan'])->name('pesanan.laporan-kerusakan');
});

// Untuk pengguna yang belum login
Route::middleware('guest')->group(function () {
    // Rute Registrasi
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

    // Rute Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    // Rute Lupa & Reset Password
    Route::get('/forgot-password', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'reset'])->name('password.update');
});

// Untuk pengguna yang sudah login (Pelanggan & Admin)
Route::middleware('auth')->group(function () {
    // Halaman Utama Pelanggan
    Route::get('/beranda', function () {
        return 'Selamat datang di Halaman Utama Pelanggan EventRent';
    })->name('pelanggan.home');

    // Rute logout global (mendukung POST dari form Blade maupun GET)
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');
});

// Khusus Panel Admin
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Rute placeholder agar link menu sidebar admin tidak error saat dirender
        Route::view('/verifikasi-ktp', 'admin.dashboard')->name('ktp.index');
        Route::get('/pemesanan', [PemesananController::class, 'index'])->name('pesanan.index');
        //Route::view('/barang', 'admin.dashboard')->name('barang.index');
        Route::resource('barang', BarangController::class)->except(['show']);
        Route::view('/laporan-kerusakan', 'admin.dashboard')->name('kerusakan.index');
    });