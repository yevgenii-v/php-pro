<?php

namespace App\Services\PaymentSystems\ConfirmPayment;

use Closure;

interface ConfirmPaymentInterface
{
    public function handle(ConfirmPaymentDTO $confirmPaymentDTO, Closure $next): ConfirmPaymentDTO;
}
