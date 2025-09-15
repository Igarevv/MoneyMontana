<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\UseCases\Commands\Expenses\RepeatableExpense\AddRepeatableExpense;

use App\CommandBus\CommandHandler;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Services\UserBalanceService;
use Modules\ExpenseAccount\app\Logs\Expenses\AddUserExpenseLogs;
use Modules\ExpenseAccount\app\Repositories\Expenses\RWriteExpenseAccounting;

class AddRepeatableExpenseHandler extends CommandHandler
{
    public function __construct(
        private RWriteExpenseAccounting $writeExpenseAccounting,
        private UserBalanceService $userBalanceService,
        private AddUserExpenseLogs $addUserExpenseLogs
    ) {
    }

    public function handle(AddRepeatableExpenseCommand $command)
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

            $this->addUserExpenseLogs->logAddingRepeatableExpense($command->expense);

            return $expense;
        });
    }
}
