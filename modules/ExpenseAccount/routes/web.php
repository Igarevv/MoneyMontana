<?php

use Illuminate\Support\Facades\Route;
use Modules\ExpenseAccount\app\Http\Controllers\ExpenseAccountingCreateController;
use Modules\ExpenseAccount\app\Http\Controllers\ExpenseAccountingRetrieveController;

Route::middleware('auth')->group(function () {
    Route::prefix('expense-accounting')->group(function () {
        Route::get('/', [ExpenseAccountingRetrieveController::class, 'index']);

        Route::post(
            '/',
            [ExpenseAccountingCreateController::class, 'addNewExpense'],
        );
    });
});
