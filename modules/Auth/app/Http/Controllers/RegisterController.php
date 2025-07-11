<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Modules\Auth\Http\RequestObjects\UserRegisterRO;
use Modules\Auth\Http\Requests\PreflightRegisterRequest;
use Modules\Auth\Http\Requests\RegisterUserRequest;
use Modules\Auth\Services\AuthUserService;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class RegisterController extends Controller
{
    public function preflightCheck(PreflightRegisterRequest $request): RedirectResponse
    {
        return redirect()->back();
    }

    public function register(RegisterUserRequest $request, AuthUserService $service): RedirectResponse
    {
        $registerRo = UserRegisterRO::fromRequest($request);

        try {
            $service->saveUser($registerRo);
        } catch (Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->withErrors([
                'message' => 'Unknown error occurred during registration',
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }

        return redirect()->back();
    }
}