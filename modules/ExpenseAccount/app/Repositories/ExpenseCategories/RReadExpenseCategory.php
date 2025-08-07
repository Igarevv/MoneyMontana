<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\Repositories\ExpenseCategories;

use Illuminate\Database\Eloquent\Collection;
use Modules\Auth\Models\User;
use Modules\ExpenseAccount\Models\ExpenseCategory;

class RReadExpenseCategory
{
    public function getGlobalCategories(array $cols = ['*']): Collection
    {
        return ExpenseCategory::query()->whereNull('user_id')->get($cols);
    }

    public function getUserPersonalCategories(User|int $user, array $cols = ['*']): Collection {}

    public function getPersonalWithGlobalsCategories(User|int $user, array $cols = ['*']): Collection
    {
        return ExpenseCategory::query()
            ->whereNull('user_id')
            ->orWhere('user_id', is_int($user) ? $user : $user->id)
            ->get($cols);
    }
}