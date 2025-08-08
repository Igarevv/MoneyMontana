<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\UseCases\Commands\Expenses\OneTimeExpense\AddOneTimeExpense;

use App\CommandBus\CommandHandler;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Services\UserBalanceService;
use Modules\ExpenseAccount\app\Logs\Expenses\AddUserExpenseLogs;
use Modules\ExpenseAccount\app\Repositories\Expenses\RWriteExpenseAccounting;
use Modules\ExpenseAccount\Jobs\SubtractExpenseFromBalanceJob;
use Modules\ExpenseAccount\Models\ExpenseAccount;

final class AddOneTimeExpenseHandler extends CommandHandler
{
    public function __construct(
        private UserBalanceService $userBalanceService,
        private RWriteExpenseAccounting $writeExpenseAccountingRepo,
        private AddUserExpenseLogs $addUserExpenseLogs,
    ) {}

    public function handle(AddOneTimeExpenseCommand $command): ExpenseAccount
    {
        return DB::transaction(function () use ($command) {
            $now = now();

            $expense = $this->writeExpenseAccountingRepo->saveExpense(
                user: $command->user,
                expenseAccountRO: $command->expense,
            );

            if ($command->expense->created_at->isBefore($now)) {
                $this->userBalanceService->subtractFromBalance($command->expense->amount);

                return $expense;
            }

            SubtractExpenseFromBalanceJob::dispatch($command->user, $expense)
                ->delay($command->expense->created_at);

            $this->addUserExpenseLogs->logAddingOneTimeExpense($command->expense);

            return $expense;
        });
    }
}