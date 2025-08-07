<?php

namespace Modules\ExpenseAccount\Http;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Modules\ExpenseAccount\Models\ExpenseCategory;

class ExpenseCategoriesExistsRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $categoriesIds = collect($value);

        $isAnyNonNumeric = $categoriesIds->filter(function ($value) {
            return ! is_numeric($value) || (int)$value !== $value;
        });

        if ($isAnyNonNumeric->isNotEmpty()) {
            $fail(__('validation.custom.all_numeric', ['attribute' => $attribute]));
        }

        if (ExpenseCategory::query()->whereIn('id', $categoriesIds->toArray())->count() !== $categoriesIds->count()) {
            $fail(__('expenseaccount::base.exceptions.not_all_categories_exists'));
        }
    }
}
