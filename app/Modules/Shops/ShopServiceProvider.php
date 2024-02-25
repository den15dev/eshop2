<?php

namespace App\Modules\Shops;

use App\Modules\Shops\Commands\AddShops;
use Illuminate\Support\ServiceProvider;

class ShopServiceProvider extends ServiceProvider
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
                AddShops::class,
            ]);
        }
    }
}
