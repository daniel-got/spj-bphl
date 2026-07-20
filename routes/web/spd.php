<?php

use App\Http\Controllers\Spd\SpdController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('spt/search', [SpdController::class, 'searchSpt'])->name('spt.search');
        Route::get('spt/{id}/ajax', [SpdController::class, 'getSptAjax'])->name('spt.ajax');
        Route::get('spd/print-blank', [SpdController::class, 'printBlank'])->name('spd.print-blank');
        Route::get('spd/{id}/print', [SpdController::class, 'print'])->name('spd.print');
        Route::resource('spd', SpdController::class);
    });
