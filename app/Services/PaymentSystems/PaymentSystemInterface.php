<?php

namespace App\Services\PaymentSystems;

use App\Services\PaymentSystems\DTO\MakePaymentDTO;

interface PaymentSystemInterface
{
    public function makePayment(MakePaymentDTO $makePaymentDTO): bool;
}
