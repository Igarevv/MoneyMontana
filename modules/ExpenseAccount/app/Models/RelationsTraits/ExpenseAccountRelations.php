<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\app\Models\RelationsTraits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Auth\Models\User;
use Modules\ExpenseAccount\app\Models\ExpenseCategory;

trait ExpenseAccountRelations
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class);
    }
}