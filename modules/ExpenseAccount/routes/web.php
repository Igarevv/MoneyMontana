<?php

use Illuminate\Support\Facades\Route;
use Modules\ExpenseAccount\Http\Controllers\ExpenseAccountController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('expenseaccounts', ExpenseAccountController::class)->names('expenseaccount');
});
