<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

    // DASHBOARD
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // JURUSAN
    Route::get('jurusan/print', [JurusanController::class, 'print'])->name('jurusan.print');
    Route::get('jurusan/export-excel', [JurusanController::class, 'exportExcel'])->name('jurusan.exportExcel');
    Route::resource('jurusan', JurusanController::class);

    // MAHASISWA
    Route::get('mahasiswa/print', [MahasiswaController::class, 'print'])->name('mahasiswa.print');
    Route::get('mahasiswa/export-excel', [MahasiswaController::class, 'exportExcel'])->name('mahasiswa.exportExcel');
    Route::get('mahasiswa/export-csv', [MahasiswaController::class, 'exportCsv'])->name('mahasiswa.exportCsv');
    Route::resource('mahasiswa', MahasiswaController::class);

    // MATAKULIAH
    Route::get('matakuliah/print', [MatakuliahController::class, 'print'])->name('matakuliah.print');
    Route::get('matakuliah/export-excel', [MatakuliahController::class, 'exportExcel'])->name('matakuliah.exportExcel');
    Route::resource('matakuliah', MatakuliahController::class);

});

require __DIR__.'/auth.php';