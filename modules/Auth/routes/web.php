<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Modules\Auth\Http\Controllers\LoginController;
use Modules\Auth\Http\Controllers\RegisterController;

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Auth/RegisterPage');
    });

    Route::post('/register/preflight', [RegisterController::class, 'preflightCheck']);

    Route::post('/register', [RegisterController::class, 'register'])
        ->middleware(['throttle:30,1']);

    Route::get('/login', function () {
        return Inertia::render('Auth/LoginPage');
    });

    Route::post('/login', [LoginController::class, 'login'])->middleware(['throttle:30,1']);
});