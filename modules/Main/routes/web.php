<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Modules\Main\Http\Controllers\MainController;

Route::middleware(['auth'])->group(function () {
    Route::name("montana")->get('/montana', function () {
        return Inertia::render('Dashboard');
    });
});