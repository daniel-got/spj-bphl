<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpdController;

Route::resource('spd', SpdController::class);