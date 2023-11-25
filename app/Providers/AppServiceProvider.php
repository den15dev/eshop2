<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Registering custom Blade component folders
        Blade::anonymousComponentPath(__DIR__.'/../../resources/views/site/components');
        Blade::anonymousComponentPath(__DIR__.'/../../resources/views/admin/components', 'admin');
    }
}
