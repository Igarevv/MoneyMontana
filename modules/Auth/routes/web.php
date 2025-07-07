<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\LoginController;
use Modules\Auth\Http\Controllers\RegisterController;

//--- REGISTRATION ---//
Route::get('/', function () {
    return \Inertia\Inertia::render('Auth/RegisterPage');
});

Route::post('/register/preflight', [RegisterController::class, 'preflightCheck']);

Route::post('/register', [RegisterController::class, 'register'])
    ->middleware(['throttle:30,1', 'guest']);

//--- LOGIN ---//
Route::get('/login', function () {
    return \Inertia\Inertia::render('Auth/LoginPage');
});

Route::post('/login', [LoginController::class, 'login'])->middleware(['throttle:30,1', 'guest']);