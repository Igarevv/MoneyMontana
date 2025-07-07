<?php

declare(strict_types=1);

namespace Modules\Auth\Http\RequestObjects;

use App\Helpers\RequestObject;

/**
 * @property string $email
 * @property string $password
 * @property bool $remember
 */
class UserLoginRO extends RequestObject
{
    public function types(): array
    {
        return [
            'email' => 'string',
            'password' => 'string',
            'remember' => 'bool'
        ];
    }

    public function toArray(array $only = []): array
    {
        if (! empty($only)) {
            return array_intersect_key(
                [
                    'email' => $this->email,
                    'password' => $this->password,
                    'remember' => $this->remember
                ],
                array_flip($only)
            );
        }

        return [
            'email' => $this->email,
            'password' => $this->password,
            'remember' => $this->remember
        ];
    }
}