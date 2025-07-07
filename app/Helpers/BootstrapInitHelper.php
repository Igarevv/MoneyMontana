<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Illuminate\Http\RedirectResponse;

final readonly class BootstrapInitHelper
{

    public function __construct(
        private Exceptions $exceptions,
    ) {}

    public static function init(Exceptions $exceptions): BootstrapInitHelper
    {
        return new self($exceptions);
    }

    public function defineRules(): BootstrapInitHelper
    {
        return $this;
    }

    public function defineRenderable(): BootstrapInitHelper
    {
        $this->renderUnexpectedErrors();

        return $this;
    }

    protected function renderUnexpectedErrors(): void
    {
        $this->exceptions->respond(function (Response $response, Throwable $exception, Request $request) {
            if (! app()->environment(['local', 'testing']) && in_array($response->getStatusCode(), [500, 503, 404, 403])) {
                return Inertia::render('ErrorPage', ['status' => $response->getStatusCode()])
                    ->toResponse($request)
                    ->setStatusCode($response->getStatusCode());
            }

            if ($response->getStatusCode() === 419) {
                return back()->with([
                    'message' => 'The page expired, please try again.',
                ]);
            }

            return $response;
        });
    }
}