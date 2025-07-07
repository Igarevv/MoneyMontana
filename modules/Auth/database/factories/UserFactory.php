<?php

declare(strict_types=1);

namespace Modules\Auth\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'username' => $this->faker->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'country_code' => $this->faker->countryCode(),
            'preferred_theme' => $this->faker->randomElement(['light', 'dark']),
            'locale' => $this->faker->randomElement(['ru', 'en']),
            'currency_code' => $this->faker->currencyCode(),
            'password' => Hash::make($this->faker->password())
        ];
    }
}