<?php

namespace App\Modules\Promos;

use App\Modules\Promos\Commands\AddPromos;
use Illuminate\Support\ServiceProvider;

class PromoServiceProvider extends ServiceProvider
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
                AddPromos::class,
            ]);
        }
    }
}
