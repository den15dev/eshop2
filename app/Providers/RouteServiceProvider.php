<?php

namespace App\Providers;

use App\Modules\Languages\LanguageService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     * Typically, users are redirected here after authentication.
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            $languagePrefix = app()->runningInConsole()
                            ? 'en'
                            : LanguageService::getRoutePrefix(request()->segment(1));

            Route::prefix($languagePrefix)
                ->group(function () {
                    Route::middleware(['web', 'site'])
                        ->group(base_path('routes/site.php'));

                    Route::middleware(['web', 'admin'])
                        ->prefix('admin')
                        ->name('admin.')
                        ->group(base_path('routes/admin.php'));
                });

            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        });
    }
}
