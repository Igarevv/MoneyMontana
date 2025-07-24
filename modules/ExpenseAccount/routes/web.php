<?php

use Illuminate\Support\Facades\Route;
use Modules\ExpenseAccount\app\Http\Controllers\ExpenseAccountingCreateController;

Route::middleware('auth')->group(function () {
    Route::prefix('expense-accounting')->group(function () {
        Route::get('/');

        Route::post(
            '/',
            [ExpenseAccountingCreateController::class, 'addNewExpense'],
        );
    });
});
