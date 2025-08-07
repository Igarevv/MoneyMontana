<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\UseCases\Commands\ExpenseCategories;

use App\CommandBus\Command;
use Modules\Auth\Models\User;
use Modules\ExpenseAccount\Http\RequestObjects\CreateExpenseCategoryRo;

/**
 * @link GetExpenseCategoriesHandler
 */
class AddExpenseCategoryCommand extends Command
{
    public function __construct(
        public readonly CreateExpenseCategoryRo $categoryRo,
        public readonly User $user,
    ) {}
}