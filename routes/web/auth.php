<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

// ========================================
// PUBLIC AUTH ROUTES
// ========================================

Route::get('/login', function () {
    return view('pages.auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ========================================
// FORCE PASSWORD CHANGE ROUTES
// ========================================
Route::middleware(['auth'])->group(function () {
    Route::get('/password/change', [\App\Http\Controllers\FirstLoginPasswordController::class, 'show'])->name('password.change.show');
    Route::post('/password/change', [\App\Http\Controllers\FirstLoginPasswordController::class, 'update'])->name('password.change.update');
});

// Dev Login Bypass for Local Environment
