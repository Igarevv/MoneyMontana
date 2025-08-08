<?php

namespace App\Enums;

enum UserLogsActionTypeEnum: int
{
    case ADD_ONE_TIME_EXPENSE = 1;

    case ADD_SUBSCRIPTION_EXPENSE = 2;

    case ADD_REPEATABLE_EXPENSE = 3;

    case BALANCE_SUBTRACT = 4;

    public static function fromString(string $type): UserLogsActionTypeEnum
    {
        return match (strtolower($type)) {
            'add_one_time_expense' => self::ADD_ONE_TIME_EXPENSE,
            'add_subscription_expense' => self::ADD_SUBSCRIPTION_EXPENSE,
            'add_repeatable_expense' => self::ADD_REPEATABLE_EXPENSE,
            'balance_subtract' => self::BALANCE_SUBTRACT,
        };
    }

    public function toString(): string
    {
        return match ($this) {
            self::ADD_ONE_TIME_EXPENSE => 'add_one_time_expense',
            self::ADD_SUBSCRIPTION_EXPENSE => 'add_subscription_expense',
            self::ADD_REPEATABLE_EXPENSE => 'add_repeatable_expense',
            self::BALANCE_SUBTRACT => 'balance_subtract',
        };
    }
}
