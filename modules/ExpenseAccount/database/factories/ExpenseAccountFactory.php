<?php

namespace Modules\ExpenseAccount\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Auth\Models\User;
use Modules\ExpenseAccount\Enums\DurationType;
use Modules\ExpenseAccount\Enums\ExpenseType;
use Modules\ExpenseAccount\Models\ExpenseAccount;

class ExpenseAccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = ExpenseAccount::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'label' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'amount' => $this->faker->randomNumber(5),
            'currency' => $this->faker->randomElement(['USD', 'EUR', 'UAH']),
        ];
    }

    public function user(User $user): ExpenseAccountFactory
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'user_id' => $user->id,
            ];
        });
    }

    public function oneTime(): ExpenseAccountFactory
    {
        return $this->state(function (array $attributes, $user) {
            return [
                'expense_type' => ExpenseType::DISPOSABLE->value,
                'duration_type' => null,
                'duration_value' => null,
                'payment_date' => null,
            ];
        });
    }

    public function subscription(): ExpenseAccountFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'expense_type' => ExpenseType::SUBSCRIPTION->value,
                'duration_type' => $this->faker->randomElement(
                    DurationType::cases()
                ),
                'duration_value' => $this->faker->numberBetween(1, 12),
                'payment_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            ];
        });
    }

    public function repeatable(): ExpenseAccountFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'expense_type' => ExpenseType::REPEATABLE->value,
                'duration_type' => null,
                'duration_value' => null,
                'payment_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            ];
        });
    }
}
