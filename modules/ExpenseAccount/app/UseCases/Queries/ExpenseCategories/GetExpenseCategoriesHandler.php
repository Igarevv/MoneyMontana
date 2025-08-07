<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\UseCases\Queries\ExpenseCategories;

use App\CommandBus\QueryHandler;
use Illuminate\Database\Eloquent\Collection;
use Modules\ExpenseAccount\app\Models\ExpenseCategory;
use Modules\ExpenseAccount\app\Repositories\ExpenseCategories\RReadExpenseCategory;

class GetExpenseCategoriesHandler extends QueryHandler
{
    public function __construct(
        private RReadExpenseCategory $categoryReadRepo,
    ) {}

    public function handle(GetExpenseCategoriesQuery $query): ?Collection
    {
        $collection = null;

        if ($query->categoryFetchType === GetExpenseCategoriesQuery::GET_GLOBAL_CATEGORIES) {
            $collection = $this->categoryReadRepo->getGlobalCategories();
        }

        if ($query->categoryFetchType === GetExpenseCategoriesQuery::GET_PERSONAL_CATEGORIES) {
            $collection = $this->categoryReadRepo->getPersonalWithGlobalsCategories($query->user);
        }

        if ($query->categoryFetchType === GetExpenseCategoriesQuery::GET_G_P_CATEGORIES) {
            $collection = $this->categoryReadRepo->getPersonalWithGlobalsCategories($query->user);
        }

        return $collection->transform(function (ExpenseCategory $category) {
            return [
                'id' => $category->id,
                'label' => $category->labelByLocale(),
                'color' => $category->color,
                'is_global' => is_null($category->user_id),
            ];
        });
    }
}