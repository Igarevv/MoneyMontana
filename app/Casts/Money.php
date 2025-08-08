<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class Money implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return \Brick\Money\Money::ofMinor($attributes[$key], $attributes['currency_code'] ?? 'USD');
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (! $value instanceof \Brick\Money\Money) {
            return $value;
        }

        return $value->getMinorAmount()->toInt();
    }
}
