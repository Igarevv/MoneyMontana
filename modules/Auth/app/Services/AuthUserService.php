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
        if (! Auth::attempt($userLoginRO->toArray(['email', 'password']), $userLoginRO->remember)) {
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
    public function me(array $only = [], bool $mustBeAuth = false): ?User
    {
        if (Auth::check()) {
            $user = Auth::user();

            if (! empty($only)) {
                $allAttributes = array_keys($user?->getAttributes());

                $hidden = array_diff($allAttributes, $only);

                $user?->makeHidden($hidden);
            }

            return $user;
        }

        if ($mustBeAuth) {
            throw new AuthenticationException();
        }

        return null;
    }
}