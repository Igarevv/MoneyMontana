<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\Models\RelationsTraits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Auth\Models\User;
use Modules\ExpenseAccount\Models\ExpenseCategory;

trait ExpenseAccountRelations
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function expenseCategories(): BelongsToMany
    {
        return $this->belongsToMany(ExpenseCategory::class, 'expense_accounts_categories');
    }
}