<?php

namespace App\Providers;

use App\Services\PaymentSystems\Stripe\StripeService;
use Illuminate\Support\ServiceProvider;
use Stripe\StripeClient;

class StripeServiceProvider extends ServiceProvider
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
        $this->app->when(StripeService::class)
            ->needs(StripeClient::class)
            ->give(function () {
                return new StripeClient(config('stripe.api_keys.secret_key'));
            });
    }
}
