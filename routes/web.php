<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;

Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {

    // DASHBOARD
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // JURUSAN
    Route::resource('jurusan', JurusanController::class);

    // MAHASISWA
    Route::resource('mahasiswa', MahasiswaController::class);

    Route::get('/mahasiswa/export-csv', [MahasiswaController::class, 'exportCsv'])
        ->name('mahasiswa.exportCsv');

    Route::get('/mahasiswa/print', [MahasiswaController::class, 'print'])
        ->name('mahasiswa.print');

    // MATAKULIAH
    Route::resource('matakuliah', MatakuliahController::class);
});