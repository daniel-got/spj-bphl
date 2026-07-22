<?php

use App\Http\Controllers\Rincian\RincianController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('rincian/spd/search', [RincianController::class, 'searchSpd'])->name('rincian.spd.search');
        Route::get('rincian/spd/{id}/ajax', [RincianController::class, 'getSpdAjax'])->name('rincian.spd.ajax');
        Route::get('rincian/{rincian}/print', [RincianController::class, 'print'])->name('rincian.print');
        Route::get('rincian/{rincian}/print-lampiran', [RincianController::class, 'printLampiran'])->name('rincian.printLampiran');
        Route::post('rincian/{rincian}/submit', [RincianController::class, 'submit'])->name('rincian.submit');
        Route::resource('rincian', RincianController::class);

        // Kwitansi Routes
        Route::get('kwitansi', [\App\Http\Controllers\Kwitansi\KwitansiController::class, 'index'])->name('kwitansi.index');
        Route::get('kwitansi/{kwitansi}/edit', [\App\Http\Controllers\Kwitansi\KwitansiController::class, 'edit'])->name('kwitansi.edit');
        Route::put('kwitansi/{kwitansi}', [\App\Http\Controllers\Kwitansi\KwitansiController::class, 'update'])->name('kwitansi.update');
        Route::get('kwitansi/{kwitansi}/print', [\App\Http\Controllers\Kwitansi\KwitansiController::class, 'print'])->name('kwitansi.print');
    });
