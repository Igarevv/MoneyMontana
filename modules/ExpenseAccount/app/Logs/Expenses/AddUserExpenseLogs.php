<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\app\Logs\Expenses;

use App\Enums\UserLogsActionTypeEnum;
use App\Models\UserLogs;
use Modules\Auth\Models\User;
use Modules\ExpenseAccount\Http\RequestObjects\AddExpenseAccountRO;
use Throwable;

class AddUserExpenseLogs
{
    public function __construct(
        protected User $user,
    ) {
    }

    public function logAddingOneTimeExpense(AddExpenseAccountRO $meta): void
    {
        try {
            UserLogs::query()->create([
                'user_id' => $this->user->user_id,
                'action_type' => UserLogsActionTypeEnum::ADD_ONE_TIME_EXPENSE,
                'description' => __('expenseaccount::base.logs.expenses.add_one_time', [
                    'expense_name' => $meta->label,
                ]),
                'meta' => [
                    'amount' => $meta->amount->getMinorAmount()->toInt(),
                    'currency' => $meta->currency->getCurrencyCode(),
                ],
            ]);
        } catch (Throwable $throwable) {
            report($throwable);
        }
    }

    public function logAddingSubscriptionExpense(AddExpenseAccountRO $meta): void
    {
        try {
            UserLogs::query()->create([
                'user_id' => $this->user->user_id,
                'action_type' => UserLogsActionTypeEnum::ADD_SUBSCRIPTION_EXPENSE,
                'description' => __('expenseaccount::base.logs.expenses.add_one_time', [
                    'expense_name' => $meta->label
                ]),
                'meta' => [
                    'amount' => $meta->amount->getMinorAmount()->toInt(),
                    'currency' => $meta->currency->getCurrencyCode(),
                ]
            ]);
        } catch (Throwable $throwable) {
            report($throwable);
        }
    }

    public function logAddingRepeatableExpense(AddExpenseAccountRO $meta): void
    {
        try {
            UserLogs::query()->create([
                'user_id' => $this->user->user_id,
                'action_type' => UserLogsActionTypeEnum::ADD_REPEATABLE_EXPENSE,
                'description' => __('expenseaccount::base.logs.expenses.add_one_time', [
                    'expense_name' => $meta->label
                ]),
                'meta' => [
                    'amount' => $meta->amount->getMinorAmount()->toInt(),
                    'currency' => $meta->currency->getCurrencyCode(),
                ]
            ]);
        } catch (Throwable $throwable) {
            report($throwable);
        }
    }
}
