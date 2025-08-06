<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\Repositories\ExpenseCategories;

use Illuminate\Database\Eloquent\Collection;
use Modules\Auth\Models\User;
use Modules\ExpenseAccount\app\Models\ExpenseCategory;

class RReadExpenseCategory
{
    public function getGlobalCategories(array $cols = ['*']): Collection
    {
        return ExpenseCategory::query()->whereNull('user_id')->get($cols);
    }

    public function getUserPersonalCategories(User|int $user, array $cols = ['*']): Collection
    {
        if (is_int($user)) {
            return ExpenseCategory::query()->where('user_id', $user)->get($cols);
        }

        return $user->expenseCategories()->get($cols);
    }

    public function getPersonalWithGlobalsCategories(User|int $user, array $cols = ['*']): Collection
    {
        return ExpenseCategory::query()
            ->whereNull('user_id')
            ->orWhere('user_id', is_int($user) ? $user : $user->id)
            ->get($cols);
    }
}