<?php

use Illuminate\Support\Facades\Route;
use Modules\ExpenseAccount\app\Http\Controllers\ExpenseCategoriesController;

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('expense-categories')->group(function () {
        Route::get(
            '/',
            [
                ExpenseCategoriesController::class,
                'getGlobalWithUsersCategories',
            ],
        );

        Route::post(
            '/',
            [
                ExpenseCategoriesController::class,
                'addCategory',
            ],
        );
    });
});
