<?php

namespace App\Services\PaymentSystems\Paypal;

use App\Enums\Currency;
use App\Services\PaymentSystems\DTO\MakePaymentDTO;
use App\Services\PaymentSystems\PaymentSystemInterface;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Throwable;

class PaypalService implements PaymentSystemInterface
{

    public function __construct(
        protected PayPalClient $payPal,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function makePayment(MakePaymentDTO $makePaymentDTO): bool
    {
        $this->payPal->setApiCredentials(config('paypal'));
        $paypalToken = $this->payPal->getAccessToken();
        $response = $this->payPal->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('success.payment'),
                "cancel_url" => route('cancel.payment'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => $this->getCurrency($makePaymentDTO->getCurrency()),
                        "value" => number_format($makePaymentDTO->getAmount(), 2)
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            return true;
        }

        return false;
    }

    private function getCurrency(Currency $currency): string
    {
        return match ($currency) {
            Currency::USD => 'USD',
            Currency::EUR => 'EUR',
        };
    }
}
