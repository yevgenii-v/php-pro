<?php

namespace App\Enums;

enum TransactionStatus: int
{
    case SUCCESS = 1;
    case FAILED = 2;
}
