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

// Dev Login Bypass for Local Environment
