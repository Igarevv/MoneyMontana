<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\app\Enums;

enum DurationType: int
{
    case DAYS = 1;
    case WEEKS = 2;
    case MONTHS = 3;
    case YEARS = 4;
    case LIFETIME = 5;

    public function toString(): string
    {
        return match ($this) {
            self::DAYS => __('duration_types.days'),
            self::WEEKS => __('duration_types.weeks'),
            self::MONTHS => __('duration_types.months'),
            self::YEARS => __('duration_types.years'),
            self::LIFETIME => __('duration_types.lifetime'),
        };
    }
}