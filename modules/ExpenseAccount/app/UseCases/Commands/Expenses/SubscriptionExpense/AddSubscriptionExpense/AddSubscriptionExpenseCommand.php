<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\UseCases\Commands\Expenses\SubscriptionExpense\AddSubscriptionExpense;

use App\CommandBus\Command;
use Modules\Auth\Models\User;
use Modules\ExpenseAccount\Http\RequestObjects\AddExpenseAccountRO;

/**
 * @link AddSubscriptionExpenseHandler
 */
class AddSubscriptionExpenseCommand extends Command
{
    public function __construct(
        public readonly User $user,
        public readonly AddExpenseAccountRO $expense,
    ) {}
}
