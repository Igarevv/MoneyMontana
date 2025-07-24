<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth'])->group(function () {
    Route::name("montana")->get('/montana', function () {
        return Inertia::render('Dashboard', [
            'title' => __('main::base.title'),
        ]);
    });
});