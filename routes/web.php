<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampaignPageController;
use App\Http\Controllers\DonationNotificationController;
use App\Http\Controllers\DonationPaymentController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =========================================================================
// 1. PUBLIK — Bisa diakses siapa saja (tamu & user yang sudah login)
// =========================================================================
Route::get('/', [CampaignPageController::class, 'home'])->name('home');

Route::view('/tentang', 'pages.about');
Route::get('/program', [CampaignPageController::class, 'index'])->name('program');
Route::view('/artikel', 'pages.artikel');
Route::view('/kontak', 'pages.contact');
Route::get('/detail/{campaign}', [CampaignPageController::class, 'show'])->name('campaigns.show');

Route::post('/donations/midtrans/snap', [DonationPaymentController::class, 'createSnapToken'])->name('donations.midtrans.snap');
Route::post('/donations/midtrans/status', [DonationPaymentController::class, 'refreshStatus'])->name('donations.midtrans.status');

// =========================================================================
// 2. TAMU — Hanya bisa diakses jika BELUM login
// =========================================================================
Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::view('/register', 'auth.register')->name('register');

    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// =========================================================================
// 3. LOGIN GOOGLE (Socialite) — Tidak perlu middleware
// =========================================================================
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

// =========================================================================
// 4. DONATUR — Sudah login dengan role 'donatur'
// =========================================================================
Route::middleware(['auth', 'role:donatur'])->group(function () {
    Route::view('/dashboard', 'dashboard.index')->name('dashboard');

    Route::get('/notifikasi', [DonationNotificationController::class, 'index'])->name('notifications');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/donations/{donation}/midtrans/resume', [DonationPaymentController::class, 'resumePayment'])->name('donations.midtrans.resume');
});

// =========================================================================
// 5. SEMUA USER LOGIN — Logout bisa dilakukan role apapun
// =========================================================================
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});