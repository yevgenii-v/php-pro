<?php

namespace App\Providers;

use App\Services\Singleton\Logger\LoggerLaravel;
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
        $this->app->singleton(LoggerLaravel::class, function () {
            return new LoggerLaravel();
        });
    }
}
