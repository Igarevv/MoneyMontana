<?php

declare(strict_types=1);

namespace App\CommandBus;

interface QueryBus
{
    public function ask(Query $query): mixed;

    public function register(array $map): void;
}