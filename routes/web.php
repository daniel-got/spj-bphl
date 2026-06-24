<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [LandingPageController::class, 'index']);
