<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Overriding the createUrlUsing so it can return the SPAs URL
        ResetPassword::createUrlUsing(function ($notifiable, $token) {
            return 'http://'.env('SPA_URL','localhost').'/' . $token . '/' . '?email=' . $notifiable->getEmailForPasswordReset();
    });
    }
}
