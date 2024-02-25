<?php

namespace App\Modules\StaticPages;

use App\Modules\StaticPages\Commands\AddStaticPageParams;
use Illuminate\Support\ServiceProvider;

class StaticPageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/Migrations');

            $this->commands([
                AddStaticPageParams::class,
            ]);
        }
    }
}
