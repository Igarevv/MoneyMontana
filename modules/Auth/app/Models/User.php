<?php

namespace Modules\Auth\Models;

use App\DefaultCasts\CurrencyCast;
use Brick\Money\Currency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Ramsey\Uuid\Uuid;

/**
 * @property string $user_id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $country
 * @property string|null $theme
 * @property string|null $locale
 * @property Currency $currency
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'country_code',
        'preferred_theme',
        'locale',
        'currency_code',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'currency' => CurrencyCast::class
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (User $user) {
            if ($user->user_id === null) {
                $user->user_id = Uuid::uuid7()->toString();
            }
        });
    }
}
