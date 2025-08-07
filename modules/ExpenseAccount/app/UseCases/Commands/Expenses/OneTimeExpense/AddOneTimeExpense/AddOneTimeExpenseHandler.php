<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\UseCases\Commands\Expenses\OneTimeExpense\AddOneTimeExpense;

use App\CommandBus\CommandHandler;
use App\Helpers\CurrencyConverter;

class AddOneTimeExpenseHandler extends CommandHandler
{
    public function handle(AddOneTimeExpenseCommand $command)
    {
        $converter = CurrencyConverter::init();

        if ($command->expense->created_at->isBefore(now())) {
        }
    }
}