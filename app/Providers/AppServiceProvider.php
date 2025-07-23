<?php

namespace App\Providers;

use App\CommandBus\CommandBus;
use App\CommandBus\IlluminateCommandBus;
use App\CommandBus\IlluminateQueryBus;
use App\CommandBus\QueryBus;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        URL::forceHttps($this->app->isProduction() && config('app.scheme') === 'https');

        $this->app->register(RouteServiceProvider::class);

        $this->app->singleton(
            CommandBus::class,
            IlluminateCommandBus::class,
        );

        $this->app->singleton(
            QueryBus::class,
            IlluminateQueryBus::class,
        );

        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
