<?php

declare(strict_types=1);

namespace App\CommandBus;

use Illuminate\Bus\Dispatcher;

class IlluminateQueryBus implements QueryBus
{
    public function __construct(private Dispatcher $dispatcher) {}

    public function ask(Query $query): mixed
    {
        return $this->dispatcher->dispatch($query);
    }

    public function register(array $map): void
    {
        $this->dispatcher->map($map);
    }
}