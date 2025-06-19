<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Modules\Auth\Http\Requests\PreflightRegisterRequest;

class RegisterController extends Controller
{
    public function preflightCheck(PreflightRegisterRequest $request): RedirectResponse
    {
        return redirect()->back();
    }

    public function register()
    {

    }
}