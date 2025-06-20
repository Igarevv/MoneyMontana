<?php

declare(strict_types=1);

namespace App\DefaultCasts;

use Brick\Money\Currency;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;

class CurrencyCast implements CastsAttributes
{
    public function get($model, string $key, mixed $value, array $attributes): Currency
    {
        try {
            return Currency::of($value);
        } catch (\Throwable $e) {
            throw new InvalidArgumentException("Invalid currency code: $value");
        }
    }

    public function set($model, string $key, mixed $value, array $attributes): string
    {
        if ($value instanceof Currency) {
            return $value->getCurrencyCode();
        }

        if (is_string($value)) {
            return strtoupper($value);
        }

        throw new InvalidArgumentException('Invalid value for currency cast.');
    }
}
