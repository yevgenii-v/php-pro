<?php

namespace App\Services\PaymentSystems;

use App\Enums\PaymentSystems;
use App\Services\PaymentSystems\Paypal\PaypalService;
use App\Services\PaymentSystems\Stripe\StripeService;
use Illuminate\Contracts\Container\BindingResolutionException;

class PaymentSystemFactory
{
    /**
     * @throws BindingResolutionException
     */
    public function getInstance(PaymentSystems $paymentSystems): PaymentSystemInterface
    {
        return match ($paymentSystems) {
            PaymentSystems::PAYPAL => app()->make(PaypalService::class),
            PaymentSystems::STRIPE => app()->make(StripeService::class),
            PaymentSystems::LIQPAY => app()->make(StripeService::class),
        };
    }
}
