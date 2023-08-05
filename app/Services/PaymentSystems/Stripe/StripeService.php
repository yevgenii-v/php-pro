<?php

namespace App\Services\PaymentSystems\Stripe;

use App\Enums\Currency;
use App\Services\PaymentSystems\DTO\MakePaymentDTO;
use App\Services\PaymentSystems\PaymentSystemInterface;
use Exception;
use Stripe\Exception\CardException;
use Stripe\StripeClient;

class StripeService implements PaymentSystemInterface
{

    public function __construct(
        protected StripeClient $stripe
    ) {
    }

    public function makePayment(MakePaymentDTO $makePaymentDTO): bool
    {
        $result = $this->stripe->charges->create([
            'amount'        => $makePaymentDTO->getAmount() * 100,
            'currency'      => $this->getCurrency($makePaymentDTO->getCurrency()),
            'source'        => 'tok_mastercard',
            'description'   => $makePaymentDTO->getDescription(),
        ]);

        return $result->status === 'succeeded';
    }

    private function getCurrency(Currency $currency): string
    {
        return match ($currency) {
            Currency::USD => 'usd',
            Currency::EUR => 'eur',
        };
    }
}
