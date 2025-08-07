<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\UseCases\Commands\Expenses\OneTimeExpense\AddOneTimeExpense;

use App\CommandBus\CommandHandler;

class AddOneTimeExpenseHandler extends CommandHandler
{
    public function handle(AddOneTimeExpenseCommand $command)
    {
        if ($command->expense->created_at->isBefore(now())) {
        }
    }
}