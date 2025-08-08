<?php

declare(strict_types=1);

namespace Modules\Auth\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class FailedToUpdateUserBalanceException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json(['message' => 'Failed to update balance.'], 500);
    }

    public function report(): false
    {
        return false;
    }
}