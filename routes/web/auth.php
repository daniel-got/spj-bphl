<?php

use Illuminate\Support\Facades\Route;

// ========================================
// PUBLIC AUTH ROUTES
// ========================================

Route::get('/login', function () {
    return view('pages.auth.login');
})->name('login');

// Dev Login Bypass for Local Environment
