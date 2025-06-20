<?php

declare(strict_types=1);

namespace Modules\Auth\Services;

use Illuminate\Support\Facades\DB;
use Modules\Auth\Http\RequestObjects\UserRegisterRO;
use Modules\Auth\Models\User;

class RegistrationService
{
    public function saveUser(UserRegisterRO $registerRO): User
    {
        return DB::transaction(function () use ($registerRO) {
            return User::query()->create([
                'username' => $registerRO->username,
                'email' => $registerRO->email,
                'password' => $registerRO->password,
                'country_code' => $registerRO->country,
                'preferred_theme' => $registerRO->theme,
                'locale' => $registerRO->locale,
                'currency_code' => $registerRO->currency,
            ]);
        });
    }
}