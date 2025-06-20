<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Auth\Http\RequestObjects\UserRegisterRO;
use Modules\Auth\Http\Requests\PreflightRegisterRequest;
use Modules\Auth\Http\Requests\RegisterUserRequest;
use Modules\Auth\Services\RegistrationService;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class RegisterController extends Controller
{
    public function preflightCheck(PreflightRegisterRequest $request): RedirectResponse
    {
        return redirect()->back();
    }

    //TODO: возраст ошибок сделать более гибким
    public function register(RegisterUserRequest $request, RegistrationService $service): RedirectResponse
    {
        $registerRo = UserRegisterRO::fromRequest($request);

        try {
            $service->saveUser($registerRo);
        } catch (Throwable $e) {
            return redirect()->back()->withErrors([
                'message' => 'Unknown error occurred during registration',
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }

        return redirect()->back();
    }
}