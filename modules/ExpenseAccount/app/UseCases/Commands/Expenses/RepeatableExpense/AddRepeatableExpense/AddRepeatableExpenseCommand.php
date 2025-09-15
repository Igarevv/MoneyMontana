<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\UseCases\Commands\Expenses\RepeatableExpense\AddRepeatableExpense;

use App\CommandBus\Command;
use Modules\Auth\Models\User;
use Modules\ExpenseAccount\Http\RequestObjects\AddExpenseAccountRO;

/**
 * @link AddRepeatableExpenseHandler
 */
class AddRepeatableExpenseCommand extends Command
{
    public function __construct(
        public readonly User $user,
        public readonly AddExpenseAccountRO $expense,
    ) {
    }
}
