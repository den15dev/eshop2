<?php

namespace App\Providers;

use App\Modules\Common\CommonService;
use App\Modules\Languages\LanguageService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        bcscale(2);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        CommonService::$app_start_time = microtime(true);

        // During development, throw an exception when attempting to fill an unfillable attribute
        Model::preventSilentlyDiscardingAttributes(!app()->isProduction());

        // Count DB queries for monitoring
        DB::listen(function() {
            CommonService::$db_query_cnt++;
        });

        // Registering custom Blade component folders
        Blade::anonymousComponentPath(__DIR__.'/../../resources/views/common/components');
        Blade::anonymousComponentPath(__DIR__.'/../../resources/views/site/components');
        Blade::anonymousComponentPath(__DIR__.'/../../resources/views/admin/components', 'admin');

        // Set default and fallback languages
        if (!app()->runningInConsole()) {
            LanguageService::setDefaultLanguage();
            LanguageService::setFallbackLanguage();
        }
    }
}
