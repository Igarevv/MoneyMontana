<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\UseCases\Commands\Expenses\SubscriptionExpense\AddSubscriptionExpense;

use App\CommandBus\CommandHandler;
use Modules\ExpenseAccount\UseCases\Commands\Expenses\OneTimeExpense\AddOneTimeExpense\AddOneTimeExpenseCommand;

class AddSubscriptionExpenseHandler extends CommandHandler
{
    public function handle(AddOneTimeExpenseCommand $command) {}
}