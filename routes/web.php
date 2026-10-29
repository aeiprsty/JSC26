<?php

use App\Http\Controllers\LaporanController;
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

Route::get('/edukasi', function () {
    return view('edukasi');
})->name('edukasi.index');

Route::get('/transparansi', function () {
    return view('transparansi');
})->name('transparansi.index');

Route::post('/laporan', [LaporanController::class, 'store'])
    ->name('laporan.store');

Route::get('/laporan/{kodeTiket}', [LaporanController::class, 'search'])
    ->name('laporan.search');