<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\AuthController;

// Rute Halaman Utama (Katalog) bisa diakses siapa saja, termasuk pengguna yang belum login
Route::get('/', [CatalogController::class, 'index'])->name('home');

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

// Untuk pengguna yang sudah login
Route::middleware('auth')->group(function () {
    // // Halaman Dashboard Admin
    // Route::get('/admin/dashboard', function () {
    //     return 'Selamat datang di Dashboard Admin EventRent';
    // })->name('admin.dashboard');

    // // Halaman Utama Pelanggan
    // Route::get('/beranda', function () {
    //     return 'Selamat datang di Halaman Utama Pelanggan EventRent';
    // })->name('pelanggan.home');

    /* 
    Rute halaman utama yang tidak dibatasi peran, karena halaman terpisah
    untuk dashboard admin/pengguna belum dibuat
    */
    Route::get('/', [CatalogController::class, 'index'])->name('home');

    // Rute logout untuk pengguna yang sudah login
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
