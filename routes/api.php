<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;

// --- SOLUSI ANTI-405 UNTUK POST & GET ---
// Menggunakan Route::any agar Laravel menerima method apapun (POST/GET) baik menggunakan '/' maupun tidak
Route::any('mahasiswa', [MahasiswaController::class, 'handleMahasiswaRoot']);
Route::any('mahasiswa/', [MahasiswaController::class, 'handleMahasiswaRoot']);

// --- JALUR PUT & DELETE (TETAP AMAN) ---
Route::put('mahasiswa/{id}', [MahasiswaController::class, 'update']);
Route::put('mahasiswa/{id}/', [MahasiswaController::class, 'update']);
Route::delete('mahasiswa/{id}', [MahasiswaController::class, 'destroy']);