<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\RegisterController;

Route::post('/register/preflight', [RegisterController::class, 'preflightCheck']);

Route::post('/register', [RegisterController::class, 'register'])
    ->middleware(['throttle:30,1', 'guest']);