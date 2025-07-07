<?php

declare(strict_types=1);

namespace Modules\Auth\Exceptions;

use Exception;
use Illuminate\Http\RedirectResponse;

class LoginFailedException extends Exception
{
    public function render(): RedirectResponse
    {
        return redirect()
            ->back()
            ->withInput()
            ->withErrors([
                'email' => __('auth.failed'),
            ]);
    }
}