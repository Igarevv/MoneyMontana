<?php

namespace Modules\Auth\Models;

use App\Casts\Money;
use App\DefaultCasts\CurrencyCast;
use Brick\Money\Currency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Auth\Database\Factories\UserFactory;
use Modules\Auth\Enums\EmploymentType;
use Modules\Auth\Models\RelationsTraits\UserRelations;
use Ramsey\Uuid\Uuid;

/**
 * @property string $user_id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $country_code
 * @property string|null $preferred_theme
 * @property string|null $locale
 * @property \Brick\Money\Money $balance
 * @property EmploymentType $employment_type
 * @property Currency $currency_code
 * @method HasMany expenseAccounts()
 * @method HasMany expenseCategories()
 */
class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use UserRelations;

    protected $fillable = [
        'username',
        'email',
        'balance',
        'password',
        'country_code',
        'preferred_theme',
        'locale',
        'currency_code',
        'employment_type',
    ];

    protected $hidden = [
        'password',
    ];

    public function subtractFromBalance(\Brick\Money\Money $money) {}

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'currency' => CurrencyCast::class,
            'employment_type' => EmploymentType::class,
            'balance' => Money::class,
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (User $user) {
            if ($user->user_id === null) {
                $user->user_id = Uuid::uuid7()->toString();
            }

            if (! $user->created_at) {
                $user->created_at = now();
            }
        });
    }

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}
