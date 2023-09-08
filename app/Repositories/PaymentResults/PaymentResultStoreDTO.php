<?php

namespace App\Repositories\PaymentResults;

use YevgeniiV\PsPackage\Enums\Currency;
use YevgeniiV\PsPackage\Enums\PaymentSystem;
use YevgeniiV\PsPackage\Enums\Status;

class PaymentResultStoreDTO
{
    protected PaymentSystem $paymentSystem;

    public function __construct(
        protected bool $status,
        protected string $orderId,
        protected string $paymentId,
        protected int $userId,
        protected string $amount,
        protected Currency $currency
    ) {
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getPaymentId(): string
    {
        return $this->paymentId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function getPaymentSystem(): PaymentSystem
    {
        return $this->paymentSystem;
    }

    public function setPaymentSystem(PaymentSystem $paymentSystem): void
    {
        $this->paymentSystem = $paymentSystem;
    }
}
