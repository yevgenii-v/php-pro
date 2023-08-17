<?php

namespace App\Services\PaymentSystems\ConfirmPayment;

use App\Enums\Currency;
use App\Enums\PaymentSystem;
use App\Enums\TransactionStatus;
use Carbon\Carbon;

class PaymentResultStoreDTO
{
    public function __construct(
        protected int $userId,
        protected PaymentSystem $paymentSystem,
        protected string $paymentId,
        protected TransactionStatus $success,
        protected float $amount,
        protected Currency $currency,
        protected Carbon $createAt,
        protected Carbon $updatedAt
    ) {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getPaymentSystem(): PaymentSystem
    {
        return $this->paymentSystem;
    }

    public function getPaymentId(): string
    {
        return $this->paymentId;
    }

    public function getSuccess(): TransactionStatus
    {
        return $this->success;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function getCreateAt(): Carbon
    {
        return $this->createAt;
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->updatedAt;
    }
}
