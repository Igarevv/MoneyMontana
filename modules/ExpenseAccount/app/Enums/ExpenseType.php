<?php

namespace Modules\ExpenseAccount\app\Enums;

enum ExpenseType: int
{
    case DISPOSABLE = 1;

    case SUBSCRIPTION = 2;

    case REPEATABLE = 3;

    public function toString(): string
    {
        return match ($this) {
            self::DISPOSABLE => __('expense_account.type.disposable'),
            self::SUBSCRIPTION => __('expense_account.type.subscription'),
            self::REPEATABLE => __('expense_account.type.repeatable'),
        };
    }
}
