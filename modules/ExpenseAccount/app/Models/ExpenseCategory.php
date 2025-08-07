<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\ExpenseAccount\Enums\ExpenseCategoriesType;
use Modules\ExpenseAccount\Models\RelationsTraits\ExpenseCategoriesRelations;

/**
 * @property int $id
 * @property array|string $label
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
        'user_id',
    ];

    public function casts(): array
    {
        return [
            'label' => 'array',
        ];
    }

    public function labelByLocale(): string|array|null
    {
        if ($this->user_id) {
            return $this->label ?? null;
        }

        return $this->label[app()->getLocale()];
    }
}