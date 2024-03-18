<?php

namespace App\Modules\Currencies;

use App\Modules\Currencies\Commands\AddCurrencies;
use App\Modules\Currencies\Commands\UpdateRates;
use Illuminate\Support\ServiceProvider;

class CurrencyServiceProvider extends ServiceProvider
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
                AddCurrencies::class,
                UpdateRates::class,
            ]);
        }
    }
}
