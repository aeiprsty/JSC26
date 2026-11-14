<?php

use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;
use App\Models\Edukasi;
use App\Models\Informasi;
use App\Models\JadwalPenjemputan;
use App\Http\Controllers\EdukasiController;

Route::get('/', function () {
    $jadwalPreview = JadwalPenjemputan::query()
        ->where('status', true)
        ->orderBy('urutan')
        ->limit(3)
        ->get();

    $videoPreview = Edukasi::query()
        ->where('jenis', 'video')
        ->where('status', 'published')
        ->where(function ($query) {
            $query->whereNull('published_at')
                ->orWhere('published_at', '<=', now());
        })
        ->latest('created_at')
        ->limit(4)
        ->get();

    $artikelPreview = Edukasi::query()
        ->where('jenis', 'artikel')
        ->where('status', 'published')
        ->where(function ($query) {
            $query->whereNull('published_at')
                ->orWhere('published_at', '<=', now());
        })
        ->latest('created_at')
        ->limit(3)
        ->get();

    return view('beranda', compact(
        'jadwalPreview',
        'videoPreview',
        'artikelPreview'
    ));
})->name('beranda');

Route::get('/lapor', function () {
    return view('lapor');
})->name('lapor.index');

Route::get('/lacak', [LaporanController::class, 'index'])
    ->name('lacak.index');

Route::get('/jadwal', function () {
    $jadwals = JadwalPenjemputan::where('status', true)
        ->orderBy('urutan')
        ->get();

    return view('jadwal', compact('jadwals'));
})->name('jadwal.index');

Route::get('/edukasi', [EdukasiController::class, 'index'])
    ->name('edukasi.index');

Route::get('/edukasi/{slug}', [EdukasiController::class, 'show'])
    ->name('edukasi.show');

Route::get('/transparansi', function () {
    $informasis = Informasi::where('status', true)
        ->orderBy('urutan')
        ->get();

    return view('transparansi', compact('informasis'));
})->name('transparansi.index');

Route::post('/laporan', [LaporanController::class, 'store'])
    ->name('laporan.store');

Route::get('/laporan/{kodeTiket}', [LaporanController::class, 'search'])
    ->name('laporan.search');
