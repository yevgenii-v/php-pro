<?php

namespace App\Services\PaymentSystems\ConfirmPayment;

use App\Enums\Currency;
use App\Enums\PaymentSystem;
use App\Enums\TransactionStatus;

class PaymentInfoDTO
{
    public function __construct(
        protected TransactionStatus $status,
        protected PaymentSystem $paymentSystem,
        protected string $orderId,
        protected string $paymentId,
        protected float $amount,
        protected Currency $currency,
        protected int $time,
        protected ?PayerDTO $payerDTO,
    ) {
    }

    public function getStatus(): TransactionStatus
    {
        return $this->status;
    }

    public function getPaymentSystem(): PaymentSystem
    {
        return $this->paymentSystem;
    }

    public function getOrderId(): string
    {
        return $this->orderId;
    }

    public function getPaymentId(): string
    {
        return $this->paymentId;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function getTime(): int
    {
        return $this->time;
    }

    public function getPayerDTO(): ?PayerDTO
    {
        return $this->payerDTO;
    }
}
