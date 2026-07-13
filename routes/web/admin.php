<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KelolaPegawaiController;
use App\Http\Controllers\Admin\SuratDasarController;
use App\Http\Controllers\Admin\UangHarianController;
use App\Http\Controllers\Admin\UangPenginapanController;
use App\Http\Controllers\Spt\SptController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Route Admin — Khusus role 'admin'
|--------------------------------------------------------------------------
| Semua route di sini dilindungi oleh dua middleware:
|   1. 'auth'       → user wajib sudah login
|   2. 'role:admin' → user wajib memiliki role admin (via CheckRole middleware)
|
| Penamaan menggunakan prefix 'admin.' agar bisa dipanggil:
|   route('admin.dashboard')
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // PDF Generate SPT
        Route::get('/spt/{id}/pdf', [SptController::class, 'generatePdf'])->name('spt.pdf');

        // Kelola Pegawai
        Route::get('/kelolaPegawai', [KelolaPegawaiController::class, 'index'])->name('kelolaPegawai');
        Route::post('/kelolaPegawai', [KelolaPegawaiController::class, 'store'])->name('kelolaPegawai.store');
        Route::put('/kelolaPegawai/{pegawai}', [KelolaPegawaiController::class, 'update'])->name('kelolaPegawai.update');
        Route::delete('/kelolaPegawai/{pegawai}', [KelolaPegawaiController::class, 'destroy'])->name('kelolaPegawai.destroy');
        Route::post('/kelolaPegawai/import', [KelolaPegawaiController::class, 'import'])->name('kelolaPegawai.import');
        Route::post('/kelolaPegawai/validate-import', [KelolaPegawaiController::class, 'validateImport'])->name('kelolaPegawai.validateImport');

        // Master Uang Harian
        Route::get('/uang-harian', [UangHarianController::class, 'index'])->name('uang-harian.index');
        Route::post('/uang-harian', [UangHarianController::class, 'store'])->name('uang-harian.store');
        Route::put('/uang-harian/{uangHarian}', [UangHarianController::class, 'update'])->name('uang-harian.update');
        Route::delete('/uang-harian/{uangHarian}', [UangHarianController::class, 'destroy'])->name('uang-harian.destroy');
        Route::post('/uang-harian/import', [UangHarianController::class, 'import'])->name('uang-harian.import');
        Route::post('/uang-harian/validate-import', [UangHarianController::class, 'validateImport'])->name('uang-harian.validateImport');

        // Master Uang Penginapan
        Route::get('/uang-penginapan', [UangPenginapanController::class, 'index'])->name('uang-penginapan.index');
        Route::post('/uang-penginapan', [UangPenginapanController::class, 'store'])->name('uang-penginapan.store');
        Route::put('/uang-penginapan/{uangPenginapan}', [UangPenginapanController::class, 'update'])->name('uang-penginapan.update');
        Route::delete('/uang-penginapan/{uangPenginapan}', [UangPenginapanController::class, 'destroy'])->name('uang-penginapan.destroy');
        Route::post('/uang-penginapan/import', [UangPenginapanController::class, 'import'])->name('uang-penginapan.import');
        Route::post('/uang-penginapan/validate-import', [UangPenginapanController::class, 'validateImport'])->name('uang-penginapan.validateImport');

        // Kelola PPK
        Route::get('/ppk', function () {
            return view('pages.admin.ppk');
        })->name('ppk');

        // Master Surat Dasar
        Route::get('/surat-dasar', [SuratDasarController::class, 'index'])->name('surat-dasar.index');
        Route::post('/surat-dasar', [SuratDasarController::class, 'store'])->name('surat-dasar.store');
        Route::put('/surat-dasar/{surat_dasar}', [SuratDasarController::class, 'update'])->name('surat-dasar.update');
        Route::delete('/surat-dasar/{surat_dasar}', [SuratDasarController::class, 'destroy'])->name('surat-dasar.destroy');
        Route::patch('/surat-dasar/{surat_dasar}/toggle', [SuratDasarController::class, 'toggle'])->name('surat-dasar.toggle');
        Route::post('/surat-dasar/sinkron', [SuratDasarController::class, 'sinkron'])->name('surat-dasar.sinkron');
    });
