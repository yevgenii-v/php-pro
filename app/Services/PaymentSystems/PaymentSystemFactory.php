<?php

namespace App\Services\PaymentSystems;

use App\Enums\PaymentSystem;
use App\Services\PaymentSystems\Liqpay\LiqpayService;
use App\Services\PaymentSystems\Paypal\PaypalService;
use App\Services\PaymentSystems\Stripe\StripeService;
use Illuminate\Contracts\Container\BindingResolutionException;

class PaymentSystemFactory
{
    /**
     * @throws BindingResolutionException
     */
    public function getInstance(PaymentSystem $paymentSystems): PaymentSystemInterface
    {
        return match ($paymentSystems) {
            PaymentSystem::PAYPAL => app()->make(PaypalService::class),
            PaymentSystem::STRIPE => app()->make(StripeService::class),
            PaymentSystem::LIQPAY => app()->make(LiqpayService::class),
        };
    }
}
