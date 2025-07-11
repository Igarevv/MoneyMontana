<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Auth\Http\RequestObjects\UserLoginRO;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Services\AuthUserService;

class LoginController extends Controller
{
    public function __construct(
        private AuthUserService $service,
    ) {}

    public function login(LoginRequest $request): RedirectResponse
    {
        $this->service->attempt(UserLoginRO::fromRequest($request));

        $request->session()->regenerate();

        return redirect()->route('montana')->with('logged_just_now', true);
    }
}