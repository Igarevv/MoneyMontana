<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\Models;

use App\Casts\Money as CastMoney;
use App\DefaultCasts\CurrencyCast;
use Brick\Money\Currency;
use Brick\Money\Money;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\ExpenseAccount\Database\Factories\ExpenseAccountFactory;
use Modules\ExpenseAccount\Enums\DurationType;
use Modules\ExpenseAccount\Enums\ExpenseType;
use Modules\ExpenseAccount\Models\RelationsTraits\ExpenseAccountRelations;

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
 * @property Carbon|null $payment_date
 * @property Carbon|null $created_at
 * @property ExpenseType $expense_type
 * @method BelongsTo user()
 * @method BelongsToMany expenseCategories()
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
        'payment_date',
        'user_id',
        'created_at',
        'expense_type'
    ];

    public function casts(): array
    {
        return [
            'currency' => CurrencyCast::class,
            'amount' => CastMoney::class,
            'duration_type' => DurationType::class,
            'created_at' => 'datetime',
            'payment_date' => 'datetime',
            'expense_type' => ExpenseType::class,
        ];
    }

    protected static function newFactory(): ExpenseAccountFactory
    {
        return ExpenseAccountFactory::new();
    }
}
