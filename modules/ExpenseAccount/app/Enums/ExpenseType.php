<?php

namespace Modules\ExpenseAccount\app\Enums;

use InvalidArgumentException;

enum ExpenseType: int
{
    case DISPOSABLE = 1;

    case SUBSCRIPTION = 2;

    case REPEATABLE = 3;

    public const string DISPOSABLE_S = 'disposable';

    public const string SUBSCRIPTION_S = 'subscription';

    public const string REPEATABLE_S = 'repeatable';

    public static function stringCases(): array
    {
        return [self::DISPOSABLE_S, self::SUBSCRIPTION_S, self::REPEATABLE_S];
    }

    public static function fromString(?string $type): ?ExpenseType
    {
        if (! $type) {
            return null;
        }

        return match (true) {
            $type === self::DISPOSABLE_S => self::DISPOSABLE,
            $type === self::SUBSCRIPTION_S => self::SUBSCRIPTION,
            $type === self::REPEATABLE_S => self::REPEATABLE,
            default => throw new InvalidArgumentException("Invalid expense type: {$type}"),
        };
    }

    public function toString(): string
    {
        return match ($this) {
            self::DISPOSABLE => __('expense_account.type.disposable'),
            self::SUBSCRIPTION => __('expense_account.type.subscription'),
            self::REPEATABLE => __('expense_account.type.repeatable'),
        };
    }
}
