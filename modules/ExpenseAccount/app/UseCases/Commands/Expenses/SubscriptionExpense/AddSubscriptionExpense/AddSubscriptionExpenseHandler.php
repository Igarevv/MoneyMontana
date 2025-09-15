<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\UseCases\Commands\Expenses\SubscriptionExpense\AddSubscriptionExpense;

use App\CommandBus\CommandHandler;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Services\UserBalanceService;
use Modules\ExpenseAccount\app\Logs\Expenses\AddUserExpenseLogs;
use Modules\ExpenseAccount\app\Repositories\Expenses\RWriteExpenseAccounting;
use Modules\ExpenseAccount\Models\ExpenseAccount;

class AddSubscriptionExpenseHandler extends CommandHandler
{
    public function __construct(
        private RWriteExpenseAccounting $writeExpenseAccounting,
        private UserBalanceService $userBalanceService,
        private AddUserExpenseLogs $addUserExpenseLogs
    ) {
    }

    public function handle(AddSubscriptionExpenseCommand $command): ExpenseAccount
    {
        return DB::transaction(function () use ($command) {
            $now = now();

            $expense = $this->writeExpenseAccounting->saveExpense(
                user: $command->user,
                expenseAccountRO: $command->expense
            );

            if ($command->expense->created_at?->isBefore($now)) {
                $this->userBalanceService->subtractFromBalance(
                    money: $command->expense->amount,
                );
            }

            $this->addUserExpenseLogs->logAddingSubscriptionExpense($command->expense);

            return $expense;
        });
    }
}
