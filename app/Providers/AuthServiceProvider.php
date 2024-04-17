<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Mail\ResetPasswordMailable;
use App\Mail\VerifyEmailMailable;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return new VerifyEmailMailable($notifiable, $url);
        });

        ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            return new ResetPasswordMailable($notifiable, $token);
        });
    }
}
