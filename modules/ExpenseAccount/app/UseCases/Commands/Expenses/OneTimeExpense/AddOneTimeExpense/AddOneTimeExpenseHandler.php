<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\UseCases\Commands\Expenses\OneTimeExpense\AddOneTimeExpense;

use App\CommandBus\CommandHandler;

class AddOneTimeExpenseHandler extends CommandHandler
{
    public function handle(AddOneTimeExpenseCommand $command)
    {
        dd($command->expense);
    }
}