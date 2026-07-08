<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Rincian\RincianController;

Route::middleware(['auth'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('rincian/spd/search', [RincianController::class, 'searchSpd'])->name('rincian.spd.search');
        Route::get('rincian/spd/{id}/ajax', [RincianController::class, 'getSpdAjax'])->name('rincian.spd.ajax');
        Route::get('rincian/{rincian}/print', [RincianController::class, 'print'])->name('rincian.print');
        Route::resource('rincian', RincianController::class);
    });
