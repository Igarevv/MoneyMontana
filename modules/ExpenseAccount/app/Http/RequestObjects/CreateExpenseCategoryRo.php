<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\app\Http\RequestObjects;

use App\Helpers\RequestObject;

/**
 * @property string $category_name
 * @property string $color
 */
class CreateExpenseCategoryRo extends RequestObject
{
    public function types(): array
    {
        return [
            'category_name' => 'string',
            'color' => 'string',
        ];
    }
}