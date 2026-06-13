<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/tentang', function () {
    return view('pages.about');
});
Route::get('/program', function () {
    return view('pages.program');
});
Route::get('/artikel', function () {
    return view('pages.artikel');
});
Route::get('/kontak', function () {
    return view('pages.contact');
});
Route::get('/detail', function () {
    return view('pages.detail-donation');
});
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

