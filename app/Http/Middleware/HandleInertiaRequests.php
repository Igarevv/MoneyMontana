<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Modules\Auth\Services\AuthUserService;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = new AuthUserService()->me(only: [
            'id',
            'user_id',
            'username',
            'email',
            'locale',
            'currency_code',
            'preferred_theme',
        ]);

        return [
            ...parent::share($request),
            'locale' => app()->getLocale(),
            'logged_just_now' => $request->session()->get('logged_just_now', false),
            'auth' => $user ? [
                'user' => [
                    'email' => $user->email,
                    'username' => $user->username,
                    'pid' => $user->user_id,
                    'id' => $user->id,
                ],
                'preferences' => [
                    'locale' => $user->locale,
                    'theme' => $user->preferred_theme,
                    'currency' => $user->currency_code,
                ],
            ] : null,
        ];
    }
}
