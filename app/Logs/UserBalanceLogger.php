<?php

declare(strict_types=1);

namespace App\Logs;

use App\Enums\UserLogsActionTypeEnum;
use App\Models\UserLogs;
use Brick\Money\Money;
use Modules\Auth\Models\User;
use Throwable;

class UserBalanceLogger
{
    public function __construct(
        protected User $user,
    ) {}

    public function logSubtract(Money $amount, Money $newBalance, ?Money $converted = null): void
    {
        try {
            if ($converted) {
                $convertedMessage = __('expenseaccount::base.logs.balance.converted', [
                    'from_amount' => $amount->formatTo('en_US'),
                    'from_currency' => $amount->getCurrency()->getCurrencyCode(),
                    'to_amount' => $converted->formatTo('en_US'),
                    'to_currency' => $converted->getCurrency()->getCurrencyCode(),
                ]);
            }

            UserLogs::query()->create([
                'user_id' => $this->user->user_id,
                'action_type' => UserLogsActionTypeEnum::BALANCE_SUBTRACT,
                'description' => __('expenseaccount::base.logs.balance.subtract', [
                    'amount' => $amount->formatTo('en_US'),
                    'currency' => $amount->getCurrency()->getCurrencyCode(),
                    'new_balance' => $newBalance->formatTo('en_US'),
                    'conversion' => $convertedMessage ?? '',
                ]),
            ]);
        } catch (Throwable $throwable) {
            report($throwable);
        }
    }
}