<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;

// Landing Page
Route::get('/', [LandingPageController::class, 'index']);

// Route berdasarkan role — pisahkan setiap role ke file tersendiri
// sesuai prinsip Role Separation di developing_clean.md
require __DIR__ . '/web/auth.php';
require __DIR__ . '/web/admin.php';
