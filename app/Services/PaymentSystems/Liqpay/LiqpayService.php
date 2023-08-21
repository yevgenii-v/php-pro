<?php

namespace App\Services\PaymentSystems\Liqpay;

use App\Enums\Currency;
use App\Enums\PaymentSystem;
use App\Enums\TransactionStatus;
use App\Repositories\Users\UserRepository;
use App\Services\PaymentSystems\ConfirmPayment\PayerDTO;
use App\Services\PaymentSystems\ConfirmPayment\PaymentInfoDTO;
use App\Services\PaymentSystems\DTO\MakePaymentDTO;
use App\Services\PaymentSystems\PaymentSystemInterface;
use LiqPay;

class LiqpayService implements PaymentSystemInterface
{

    public function __construct(
        protected LiqPay $liqPay,
        protected UserRepository $userRepository,
    ) {
    }

    public function validatePayment(string $paymentId): PaymentInfoDTO
    {
        $response = $this->liqPay->api("request", [
            'action'    => 'status',
            'version'   => '3',
            'order_id'  => $paymentId,
        ]);

        return new PaymentInfoDTO(
            $this->getStatus($response->status),
            PaymentSystem::LIQPAY,
            $response->order_id,
            (int)$response->transaction_id,
            $response->amount,
            $this->getCurrency($response->currency),
            (int)substr($response->create_date, 0, 10),
            new PayerDTO(
                null,
                null,
                null,
                $response->ip,
            ),
        );
    }

    public function createPayment(MakePaymentDTO $makePaymentDTO): string
    {
        $data = $this->liqPay->cnb_form_raw([
            'version'       => '3',
            'amount'        => $makePaymentDTO->getAmount(),
            'currency'      => $this->getCurrencyForDTO($makePaymentDTO->getCurrency()),
            'description'   => $makePaymentDTO->getDescription(),
            'order_id'      => $makePaymentDTO->getOrderId(),
            'action'        => 'pay'
        ]);

        $result = ['id' => $data['data'], 'sig' => $data['signature']];

        return json_encode($result, true);
    }

    private function getCurrency(string $currency): Currency
    {
        return match ($currency) {
            'USD' => Currency::USD,
            default => Currency::EUR,
        };
    }

    private function getCurrencyForDTO(Currency $currency): string
    {
        return match ($currency) {
            Currency::USD => 'USD',
            Currency::EUR => 'EUR',
        };
    }

    private function getStatus(string $transactionStatus): TransactionStatus
    {
        return match ($transactionStatus) {
            'success' => TransactionStatus::SUCCESS,
            default => TransactionStatus::FAILED,
        };
    }
}
