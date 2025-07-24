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
 * @property array $label
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

    public function casts(): array
    {
        return [
            'label' => 'array',
        ];
    }

    public function toLocale(): ?string
    {
        if ($this->user_id) {
            return $this->label['default'] ?? null;
        }

        return $this->label[app()->getLocale()];
    }
}