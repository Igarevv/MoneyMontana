<?php

namespace Modules\Auth\Models\RelationsTraits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\ExpenseAccount\app\Models\ExpenseAccount;
use Modules\ExpenseAccount\app\Models\ExpenseCategory;

trait UserRelations
{
    public function expenseAccounts(): HasMany
    {
        return $this->hasMany(ExpenseAccount::class);
    }

    public function expenseCategories(): HasMany
    {
        return $this->hasMany(ExpenseCategory::class);
    }
}