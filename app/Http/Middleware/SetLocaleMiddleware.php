<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $_COOKIE['locale'] ?? null;

        if (array_key_exists($locale, config('app.available_locales'))) {
            app()->setLocale($locale);
        } else {
            $request->cookies->set('locale', config('app.locale'));
        }

        return $next($request);
    }
}
