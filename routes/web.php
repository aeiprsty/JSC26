<?php

use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/laporan', [LaporanController::class, 'store'])
    ->name('laporan.store');