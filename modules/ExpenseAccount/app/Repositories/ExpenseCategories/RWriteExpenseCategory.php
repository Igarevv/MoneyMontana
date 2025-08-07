<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\Repositories\ExpenseCategories;

use Modules\Auth\Models\User;
use Modules\ExpenseAccount\Http\RequestObjects\CreateExpenseCategoryRo;
use Modules\ExpenseAccount\Models\ExpenseCategory;

class RWriteExpenseCategory
{
    public function createPersonalCategory(User $user, CreateExpenseCategoryRo $categoryRo)
    {
        return ExpenseCategory::query()->create([
            'label' => $categoryRo->category_name,
            'color' => $categoryRo->color,
            'user_id' => $user->id,
        ]);
    }
}