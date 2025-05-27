<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Foundation\Configuration\Exceptions;

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
        return $this;
    }
}