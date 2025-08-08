<?php

declare(strict_types=1);

namespace Modules\Auth\Services;

use App\Logs\UserBalanceLogger;
use Brick\Math\RoundingMode;
use Brick\Money\CurrencyConverter;
use Brick\Money\Money;
use Modules\Auth\Models\User;

class UserBalanceService
{

    public function __construct(
        protected User $user,
        protected CurrencyConverter $currencyConverter,
        protected UserBalanceLogger $userBalanceLogger,
    ) {}

    public function subtractFromBalance(Money $money): Money
    {
        if ($money->getCurrency()->is($this->user->currency_code)) {
            $newBalance = $this->user->balance->minus($money);

            $this->updateBalance($newBalance);

            $this->userBalanceLogger->logSubtract($money, $newBalance);

            return $newBalance;
        }

        $convertedAmount = $this->currencyConverter->convert(
            moneyContainer: $money,
            currency: $this->user->currency_code,
            roundingMode: RoundingMode::DOWN,
        );

        $newBalance = $this->user->balance->minus($convertedAmount);

        $this->updateBalance($newBalance);

        $this->userBalanceLogger->logSubtract($money, $newBalance, $convertedAmount);

        return $newBalance;
    }

    protected function updateBalance(Money $newBalance): void
    {
        $this->user->balance = $newBalance;

        $this->user->save();
    }
}