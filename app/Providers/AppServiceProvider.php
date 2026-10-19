<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        // Pastikan asset & URL selalu menggunakan HTTPS jika diakses lewat Cloudflare Tunnel atau reverse proxy
        if (request()->server('HTTP_X_FORWARDED_PROTO') === 'https' ||
            request()->header('X-Forwarded-Proto') === 'https' ||
            str_contains((string) request()->getHost(), 'trycloudflare.com') ||
            app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
