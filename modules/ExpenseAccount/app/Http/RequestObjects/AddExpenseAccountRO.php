<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\Http\RequestObjects;

use App\Helpers\RequestObject;
use Modules\ExpenseAccount\Enums\DurationType;
use Modules\ExpenseAccount\Enums\ExpenseType;

class AddExpenseAccountRO extends RequestObject
{
    public function types(): array
    {
        return [
            'type' => [ExpenseType::class, 'fromString'],
            'label' => 'string',
            'description' => 'string',
            'amount' => 'string',
            'currency' => 'string',
            'duration_type' => [DurationType::class, 'fromString'],
            'duration_value' => 'int',
            'categories' => 'array',
        ];
    }
}