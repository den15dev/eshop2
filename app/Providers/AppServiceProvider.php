<?php

namespace App\Providers;

use App\Models\Language;
use App\Services\Common\CommonService;
use Illuminate\Support\Carbon;
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
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureForCLI();

        DB::listen(function() {
            CommonService::$db_query_cnt++;
        });

        // Registering custom Blade component folders
        Blade::anonymousComponentPath(__DIR__.'/../../resources/views/common/components');
        Blade::anonymousComponentPath(__DIR__.'/../../resources/views/site/components');
        Blade::anonymousComponentPath(__DIR__.'/../../resources/views/admin/components', 'admin');

        // Get default and fallback languages
        $this->setDefaultLanguage();
        $this->setFallbackLanguage();
    }


    private function configureForCLI(): void
    {
        if (!app()->environment(['production']) && !request()->server('SERVER_ADDR')) {
            config([
                'database.connections.pgsql.host' => env('APP_URL'),
                'database.redis.default.host' => env('APP_URL'),
                'database.redis.cache.host' => env('APP_URL'),
            ]);
        }
    }


    private function setDefaultLanguage(): void
    {
        $default_language = Language::getDefault();
        if ($default_language) {
            Language::setLocale($default_language->id);
        }
    }


    private function setFallbackLanguage(): void
    {
        $fb_language = Language::getFallback();
        if ($fb_language) {
            app()->setFallbackLocale($fb_language->id);
            Carbon::setFallbackLocale($fb_language->id);
        }
    }
}
