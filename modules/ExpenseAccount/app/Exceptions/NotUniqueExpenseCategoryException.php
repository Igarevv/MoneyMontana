<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\app\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class NotUniqueExpenseCategoryException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json(['message' => 'Category already exists.'], 429);
    }
}