<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\Http\RequestObjects;

use App\Helpers\RequestObject;
use Brick\Money\Currency;
use Brick\Money\Money;
use Carbon\Carbon;
use Modules\ExpenseAccount\Enums\DurationType;
use Modules\ExpenseAccount\Enums\ExpenseType;

/**
 * @property ExpenseType $type
 * @property string $label
 * @property string|null $description
 * @property Money $amount
 * @property Currency $currency
 * @property DurationType|null $duration_type
 * @property integer $duration_value
 * @property array $categories
 * @property Carbon $created_at
 */
class AddExpenseAccountRO extends RequestObject
{
    public function types(): array
    {
        return [
            'type' => [ExpenseType::class, 'fromString'],
            'label' => 'string',
            'created_at' => [Carbon::class, 'parse'],
            'description' => 'string',
            'amount' => [Money::class, 'of', ['currency']],
            'currency' => [Currency::class, 'of'],
            'duration_type' => [DurationType::class, 'fromString'],
            'duration_value' => 'int',
            'categories' => 'array',
        ];
    }
}