<?php

namespace App\Providers;

use App\Services\PaymentSystems\Liqpay\LiqpayService;
use Illuminate\Support\ServiceProvider;
use LiqPay;
use Stripe\StripeClient;

class LiqPayServiceProvider extends ServiceProvider
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
        $this->app->when(LiqpayService::class)
            ->needs(LiqPay::class)
            ->give(function () {
                return new LiqPay(
                    config('liqpay.liqpay.public_key'),
                    config('liqpay.liqpay.private_key')
                );
            });
    }
}
