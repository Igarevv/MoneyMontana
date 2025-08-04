<?php

namespace Modules\ExpenseAccount\Services;

use Illuminate\Database\Eloquent\Collection;
use Modules\Auth\Models\User;
use Modules\ExpenseAccount\app\Models\ExpenseCategory;

class ExpenseCategoriesService
{
    public function getGlobalWithUsersCategories(User $user): Collection
    {
        return ExpenseCategory::query()
            ->whereNull('user_id')
            ->orWhere('user_id', $user->id)
            ->get([
                'id',
                'label',
                'color',
                'user_id',
            ])
            ->transform(function (ExpenseCategory $category) use ($user) {
                return [
                    'id' => $category->id,
                    'label' => $category->label,
                    'color' => $category->color,
                    'is_global' => is_null($category->user_id),
                ];
            });
    }
}
