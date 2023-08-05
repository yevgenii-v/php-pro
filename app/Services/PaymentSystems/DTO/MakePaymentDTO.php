<?php

namespace App\Services\PaymentSystems\DTO;

use App\Enums\Currency;

class MakePaymentDTO
{
    public function __construct(
        protected float $amount,
        protected Currency $currency,
        protected string $description = '',
    ) {
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
