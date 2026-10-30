<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {
    return view('welcome');
});

// Endpoint kirim laporan dengan pengamanan throttle (maksimal 5 kali request per 1 menit)
Route::post('/laporan', [LaporanController::class, 'store'])
    ->middleware('throttle:5,1');