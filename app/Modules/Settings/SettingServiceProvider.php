<?php

namespace App\Modules\Settings;

use App\Modules\Settings\Commands\AddSettings;
use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
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
                AddSettings::class,
            ]);
        }
    }
}
