<?php

namespace Modules\Auth\Models\RelationsTraits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\ExpenseAccount\app\Models\ExpenseAccount;

trait UserRelations
{
    public function expenseAccounts(): HasMany
    {
        return $this->hasMany(ExpenseAccount::class);
    }
}