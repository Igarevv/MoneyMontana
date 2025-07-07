<?php

declare(strict_types=1);

namespace Modules\Auth\Services;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Exceptions\LoginFailedException;
use Modules\Auth\Http\RequestObjects\UserLoginRO;
use Modules\Auth\Http\RequestObjects\UserRegisterRO;
use Modules\Auth\Models\User;

class AuthUserService
{
    /**
     * @throws LoginFailedException
     */
    public function attempt(UserLoginRO $userLoginRO): void
    {
        if (! Auth::attempt($userLoginRO->toArray(), $userLoginRO->remember)) {
            throw new LoginFailedException();
        }
    }

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

    /**
     * @throws AuthenticationException
     */
    public function me(): ?Authenticatable
    {
        if (Auth::check()) {
            return Auth::user();
        }

        throw new AuthenticationException();
    }
}