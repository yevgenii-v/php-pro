<?php

namespace App\Services\PaymentSystems;

use App\Services\PaymentSystems\ConfirmPayment\PaymentInfoDTO;
use App\Services\PaymentSystems\DTO\MakePaymentDTO;

interface PaymentSystemInterface
{
    public function validatePayment(string $paymentId): PaymentInfoDTO;

    public function createPayment(MakePaymentDTO $makePaymentDTO): string;
}
