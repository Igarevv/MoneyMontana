<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class RegisterUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed'],
            'currency' => ['required', 'string', 'max:3'],
            'country' => ['required', 'string', 'max:2'],
            'theme' => ['nullable', Rule::in(['light', 'dark'])],
            'locale' => ['nullable', Rule::in(array_keys(config('app.available_locales')))],
            'employment_type' => ['required', Rule::in([
                'student',
                'unemployed',
                'employed'
            ])],
        ];
    }
}