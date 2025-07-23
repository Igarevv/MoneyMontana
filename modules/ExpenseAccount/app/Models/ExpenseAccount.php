<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\app\Models;

use App\Casts\Money;
use App\DefaultCasts\CurrencyCast;
use Brick\Money\Currency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\ExpenseAccount\app\Enums\DurationType;
use Modules\ExpenseAccount\app\Models\RelationsTraits\ExpenseAccountRelations;

/**
 * @property int $id
 * @property string $label
 * @property string|null $description
 * @property int|null $category_id
 * @property Money $amount
 * @property Currency $currency
 * @property DurationType|null $duration_type
 * @property int|null $duration_value
 * @property int $user_id
 * @method BelongsTo user()
 */
class ExpenseAccount extends Model
{
    use HasFactory;
    use ExpenseAccountRelations;

    public $timestamps = false;

    protected $table = 'expense_accounts';

    protected $fillable = [
        'label',
        'description',
        'category_id',
        'amount',
        'currency',
        'duration_type',
        'duration_value',
        'user_id',
    ];

    public function casts(): array
    {
        return [
            'currency' => CurrencyCast::class,
            'amount' => Money::class,
            'duration_type' => DurationType::class,
        ];
    }
}