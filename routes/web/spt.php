<?php

use App\Http\Controllers\SptController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        
        // Resource route otomatis untuk kelola data SPT
        Route::resource('spt', SptController::class);
    });