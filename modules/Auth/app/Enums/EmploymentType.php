<?php

declare(strict_types=1);

namespace Modules\Auth\Enums;

use InvalidArgumentException;

enum EmploymentType: int
{
    case UNEMPLOYED = 1;

    case EMPLOYED = 2;

    case STUDENT = 3;

    public static function fromString(string $value): self
    {
        return match ($value) {
            'unemployed' => self::UNEMPLOYED,
            'employed' => self::EMPLOYED,
            'student' => self::STUDENT,
            default => throw new InvalidArgumentException('Invalid employment type')
        };
    }

    public function toString(): string
    {
        return match ($this) {
            self::UNEMPLOYED => __('employment.type.unemployed'),
            self::EMPLOYED => __('employment.type.employed'),
            self::STUDENT => __('employment.type.student'),
        };
    }
}