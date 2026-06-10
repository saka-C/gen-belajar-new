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

