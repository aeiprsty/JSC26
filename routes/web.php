<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('beranda');
});

Route::get('/lapor', function () {
    return view('lapor');
})->name('lapor.index');

Route::get('/lacak', function () {
    return view('lacak');
})->name('lacak.index');

Route::get('/jadwal', function () {
    return view('jadwal');
})->name('jadwal.index');

Route::get('/transparansi', function () {
    return view('transparansi');
})->name('transparansi.index');

Route::get('/edukasi', function () {
    return view('edukasi');
})->name('edukasi.index');