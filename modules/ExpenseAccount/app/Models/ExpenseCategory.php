<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\ExpenseAccount\app\Enums\ExpenseCategoriesType;
use Modules\ExpenseAccount\app\Models\RelationsTraits\ExpenseCategoriesRelations;

/**
 * @property int $id
 * @property string $label
 * @property string $color
 * @property int $user_id
 * @method BelongsTo expenseAccount()
 * @method BelongsTo user()
 */
class ExpenseCategory extends Model
{
    use HasFactory;
    use ExpenseCategoriesRelations;

    public $timestamps = false;

    protected $table = 'expense_categories';

    protected $fillable = [
        'label',
        'color',
    ];
}