<?php

namespace App\Services\PaymentSystems\Paypal;

use App\Enums\Currency;
use App\Enums\PaymentSystem;
use App\Enums\TransactionStatus;
use App\Services\PaymentSystems\ConfirmPayment\PayerDTO;
use App\Services\PaymentSystems\ConfirmPayment\PaymentInfoDTO;
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
    public function validatePayment(string $paymentId): PaymentInfoDTO
    {
        $this->payPal->setApiCredentials(config('paypal'));
        $this->payPal->getAccessToken();
        $result = $this->payPal->capturePaymentOrder($paymentId);

        return new PaymentInfoDTO(
            $this->getStatus($result['status']),
            PaymentSystem::PAYPAL,
            $result['id'],
            $result['purchase_units']['0']['payments']['captures']['0']['id'] ?? '',
            $result['purchase_units']['0']['payments']['captures']['0']['amount']['value'] ?? '',
            $this->getCurrencyDTO(
                $result['purchase_units']['0']['payments']['captures']['0']['amount']['currency_code'] ?? ''
            ),
            strtotime($result['purchase_units']['0']['payments']['captures']['0']['create_time'] ?? time()),
            new PayerDTO(
                ($result['name']['given_name'] ?? '') . ' ' . ($result['name']['surname'] ?? ''),
                $result['email_address'] ?? null,
                null,
                null,
            ),
        );
    }

    /**
     * @throws Throwable
     */
    public function createPayment(MakePaymentDTO $makePaymentDTO): string
    {
        $this->payPal->setApiCredentials(config('paypal'));
        $paypalToken = $this->payPal->getAccessToken();
        $response = $this->payPal->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => $this->getCurrency($makePaymentDTO->getCurrency()),
                        "value" => number_format($makePaymentDTO->getAmount(), 2, '.')
                    ]
                ]
            ]
        ]);

        $result = ['id' => ''];

        if (isset($response['id']) && $response['id'] != null) {
            $result = ['id' => $response['id']];
        }

        return json_encode($result, true);
    }

    private function getCurrency(Currency $currency): string
    {
        return match ($currency) {
            Currency::USD => 'USD',
            Currency::EUR => 'EUR',
        };
    }

    private function getCurrencyDTO(string $currency): Currency
    {
        return match ($currency) {
            'USD'   => Currency::USD,
            default => Currency::EUR,
        };
    }

    private function getStatus(string $status): TransactionStatus
    {
        return match ($status) {
            'COMPLETED' => TransactionStatus::SUCCESS,
            default     => TransactionStatus::FAILED,
        };
    }
}
