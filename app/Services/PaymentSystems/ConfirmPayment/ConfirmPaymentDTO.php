<?php

namespace App\Services\PaymentSystems\ConfirmPayment;

use App\Enums\PaymentSystem;
use App\Enums\TransactionStatus;

class ConfirmPaymentDTO
{
    protected TransactionStatus $paymentSuccess;

    public function __construct(
        protected PaymentSystem $paymentSystems,
        protected string        $paymentId,
    ) {
    }

    public function paymentStatus(): TransactionStatus
    {
        return $this->paymentSuccess;
    }

    public function getPaymentSystems(): PaymentSystem
    {
        return $this->paymentSystems;
    }

    public function getPaymentId(): string
    {
        return $this->paymentId;
    }

    public function setPaymentStatus(TransactionStatus $paymentSuccess): void
    {
        $this->paymentSuccess = $paymentSuccess;
    }
}
