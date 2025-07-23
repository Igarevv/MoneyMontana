<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\app\Enums;

enum ExpenseCategoriesType: int
{
    case GLOBAL = 1;

    case PERSONAL = 2;

    public function toString(): string
    {
        return match ($this) {
            self::GLOBAL => __('expense_account.category.global'),
            self::PERSONAL => __('expense_account.category.personal'),
        };
    }
}