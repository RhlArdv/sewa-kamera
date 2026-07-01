<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Override public path for cPanel shared hosting (public → public_html)
        // When CPANEL_PUBLIC_PATH is set in .env, Laravel will use public_html instead of public
        if (env('CPANEL_PUBLIC_PATH')) {
            $this->app->bind('path.public', function () {
                return base_path(env('CPANEL_PUBLIC_PATH'));
            });
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
