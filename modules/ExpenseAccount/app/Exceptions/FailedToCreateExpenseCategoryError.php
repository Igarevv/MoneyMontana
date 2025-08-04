<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\app\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class FailedToCreateExpenseCategoryError extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json(['message' => __('expensecategory::base.exceptions.failed_cr_category')]);
    }

    public function report(): false
    {
        return false;
    }
}