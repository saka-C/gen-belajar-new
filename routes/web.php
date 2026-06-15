<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Rute Halaman Statis (Publik)
Route::view('/', 'index');
Route::view('/tentang', 'pages.about');
Route::view('/program', 'pages.program');
Route::view('/artikel', 'pages.artikel');
Route::view('/kontak', 'pages.contact');
Route::view('/detail', 'pages.detail-donation');

// 2. Rute untuk Tamu (Guest)
// Hanya bisa diakses jika user BELUM login
Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::view('/register', 'auth.register')->name('register');

    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// 3. Rute Login Google (Socialite)
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

// 4. Rute yang Memerlukan Login
Route::middleware(['auth'])->group(function () {
    // Profil
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Logout (Harus di dalam middleware auth agar aman)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
