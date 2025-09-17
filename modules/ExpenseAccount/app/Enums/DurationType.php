<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\Enums;

use Carbon\Carbon;
use InvalidArgumentException;

enum DurationType: int
{
    case DAYS = 1;
    case WEEKS = 2;
    case MONTHS = 3;
    case YEARS = 4;
    case LIFETIME = 5;

    public const string DAYS_S = 'days';

    public const string WEEKS_S = 'weeks';

    public const string MONTHS_S = 'months';

    public const string YEARS_S = 'years';

    public const string LIFETIME_S = 'lifetime';

    public static function stringCases(): array
    {
        return [
            self::DAYS_S,
            self::WEEKS_S,
            self::MONTHS_S,
            self::YEARS_S,
            self::LIFETIME_S,
        ];
    }

    public static function fromString(?string $type): ?DurationType
    {
        if (is_null($type)) {
            return null;
        }

        return match (true) {
            $type === self::DAYS_S => self::DAYS,
            $type === self::WEEKS_S => self::WEEKS,
            $type === self::MONTHS_S => self::MONTHS,
            $type === self::YEARS_S => self::YEARS,
            $type === self::LIFETIME_S => self::LIFETIME,
            default => throw new InvalidArgumentException("Invalid duration type: {$type}"),
        };
    }

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

    public static function nextPaymentDateBy(
        ?Carbon $currentPaymentDate,
        ?self $durationType,
        ?int $durationValue
    ): ?Carbon {
        if (is_null($currentPaymentDate) || is_null($durationType) || is_null($durationValue)) {
            return null;
        }

        return match ($durationType) {
            self::DAYS => $currentPaymentDate->copy()->addDays($durationValue),
            self::WEEKS => $currentPaymentDate->copy()->addWeeks($durationValue),
            self::MONTHS => $currentPaymentDate->copy()->addMonths($durationValue),
            self::YEARS => $currentPaymentDate->copy()->addYears($durationValue),
            self::LIFETIME => null,
        };
    }
}
