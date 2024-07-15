<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\CacheManager;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Log::info('Register method called in AppServiceProvider');
        $this->app->bind('files', function ($app) {
            return new \Illuminate\Filesystem\Filesystem();
        });

        $this->app->singleton('cache', function ($app) {
            Log::info('Cache binding in AppServiceProvider');
            return new CacheManager($app);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Log::info('Boot method called in AppServiceProvider');
    }
}
