<?php

namespace App\Services\PaymentSystems\Liqpay;

use App\Services\PaymentSystems\DTO\MakePaymentDTO;
use App\Services\PaymentSystems\PaymentSystemInterface;

class LiqpayService implements PaymentSystemInterface
{

    public function makePayment(MakePaymentDTO $makePaymentDTO): bool
    {
        return false;
    }
}
