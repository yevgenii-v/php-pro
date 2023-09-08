<?php

namespace App\Services\PaymentSystems\ConfirmPayment;

use YevgeniiV\PsPackage\Enums\PaymentSystem;
use YevgeniiV\PsPackage\PaymentSystems\DTO\PaymentInfoDTO;

class ConfirmPaymentDTO
{
    protected bool $paymentSuccess;
    protected PaymentInfoDTO $paymentInfoDTO;

    public function __construct(
        protected PaymentSystem $paymentSystem,
        protected string $paymentId,
    ) {
    }

    public function isPaymentSuccess(): bool
    {
        return $this->paymentSuccess;
    }

    public function setPaymentSuccess(bool $paymentSuccess): void
    {
        $this->paymentSuccess = $paymentSuccess;
    }

    public function getPaymentSystem(): PaymentSystem
    {
        return $this->paymentSystem;
    }

    public function getPaymentId(): string
    {
        return $this->paymentId;
    }

    public function setPaymentInfo(PaymentInfoDTO $paymentInfoDTO): void
    {
        $this->paymentInfoDTO = $paymentInfoDTO;
    }

    public function getPaymentInfo(): PaymentInfoDTO
    {
        return $this->paymentInfoDTO;
    }
}
