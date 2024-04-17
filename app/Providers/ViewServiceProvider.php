<?php

namespace App\Providers;

use App\View\Composers\EmailLayoutComposer;
use App\View\Composers\LayoutComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
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
        // Passing data for main layout
        View::composer('site.layout', LayoutComposer::class);

        // Passing data for emails layout
        View::composer('emails.*', EmailLayoutComposer::class);
    }
}
