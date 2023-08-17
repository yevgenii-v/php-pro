<?php

namespace App\Repositories\PaymentResults;

use App\Enums\Currency;
use App\Enums\PaymentSystem;
use App\Enums\TransactionStatus;
use App\Repositories\Users\Iterators\UserIterator;

class PaymentResultStoreDTO
{
    protected PaymentSystem $paymentSystem;

    public function __construct(
        protected TransactionStatus $status,
        protected string $orderId,
        protected string $paymentId,
        protected int $userId,
        protected string $amount,
        protected Currency $currency
    ) {
    }

    public function getStatus(): TransactionStatus
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
