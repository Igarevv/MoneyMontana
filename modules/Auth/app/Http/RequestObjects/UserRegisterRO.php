<?php

declare(strict_types=1);

namespace Modules\Auth\Http\RequestObjects;

use App\Helpers\RequestObject;
use Brick\Money\Currency;

/**
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $country
 * @property string|null $theme
 * @property string|null $locale
 * @property Currency $currency
 */
class UserRegisterRO extends RequestObject
{
    public function types(): array
    {
        return [
            'username' => 'string',
            'email' => 'string',
            'password' => 'string',
            'currency' => [Currency::class, 'of'],
            'country' => 'string',
            'theme' => 'string#light',
            'locale' => 'string#en',
        ];
    }
}