<?php

declare(strict_types=1);

namespace Modules\Auth\Tests\Unit\Services;

use App\Logs\UserBalanceLogger;
use Brick\Money\Money;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase;
use Modules\Auth\Models\User;
use Modules\Auth\Services\UserBalanceService;

class UserBalanceServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected UserBalanceService $userBalanceService;

    protected \Brick\Money\CurrencyConverter $currencyConverter;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()
            ->state(['currency_code' => 'USD'])
            ->create();

        $this->currencyConverter = \App\Helpers\CurrencyConverter::init();

        $this->userBalanceService = new UserBalanceService(
            user: $this->user,
            currencyConverter: $this->currencyConverter,
            userBalanceLogger: new UserBalanceLogger($this->user)
        );
    }

    public function test_subtract_from_balance_same_currency(): void
    {
        $amountToSubtract = Money::of(200, 'USD');

        $this->user->balance = Money::of(1000, 'USD');

        $this->user->save();

        $newBalance = $this->userBalanceService->subtractFromBalance($amountToSubtract);

        $expectedBalance = Money::of(800, 'USD');

        $this->assertTrue($expectedBalance->isEqualTo($newBalance));

        $this->assertTrue($expectedBalance->isEqualTo($this->user->balance));
    }

    public function test_subtract_from_balance_other_currency(): void
    {
        $amountToSubtract = Money::of(100, 'EUR');

        $userMoney = Money::of(1000, 'USD');

        $this->user->balance = $userMoney;

        $this->user->currency_code = 'USD';

        $this->user->save();

        $convertedAmount = $this->currencyConverter->convert(
            moneyContainer: $amountToSubtract,
            currency: $this->user->currency_code,
            roundingMode: \Brick\Math\RoundingMode::DOWN
        );

        $expectedBalance = $this->user->balance->minus($convertedAmount);

        $newBalance = $this->userBalanceService->subtractFromBalance($amountToSubtract);

        $this->assertTrue($expectedBalance->isEqualTo($newBalance));

        $this->assertTrue($expectedBalance->isEqualTo($this->user->balance));
    }

    public function test_subtract_from_balance_with_zero_amount(): void
    {
        $amountToSubtract = Money::of(0, 'USD');

        $newBalance = $this->userBalanceService->subtractFromBalance($amountToSubtract);

        $this->assertTrue($this->user->balance->isEqualTo($newBalance));
    }
}
