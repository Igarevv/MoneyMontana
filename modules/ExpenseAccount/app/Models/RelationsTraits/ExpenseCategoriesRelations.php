<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\app\Models\RelationsTraits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\ExpenseAccount\app\Models\ExpenseAccount;

trait ExpenseCategoriesRelations
{
    public function expenseAccount(): BelongsTo
    {
        return $this->belongsTo(ExpenseAccount::class);
    }
}