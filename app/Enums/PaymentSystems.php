<?php

namespace App\Enums;

enum PaymentSystems: int
{
    case PAYPAL = 1;
    case STRIPE = 2;
    case LIQPAY = 3;
}
