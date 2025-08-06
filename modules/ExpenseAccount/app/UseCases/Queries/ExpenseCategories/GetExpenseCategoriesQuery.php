<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\UseCases\Queries\ExpenseCategories;

use App\CommandBus\Query;
use Modules\Auth\Models\User;

/**
 * @link GetExpenseCategoriesHandler
 */
class GetExpenseCategoriesQuery extends Query
{
    public const int GET_GLOBAL_CATEGORIES = 0;
    public const int GET_PERSONAL_CATEGORIES = 1;
    public const int GET_G_P_CATEGORIES = 2;

    public function __construct(
        public readonly int $categoryFetchType = 0,
        public readonly ?User $user = null,
    ) {}
}