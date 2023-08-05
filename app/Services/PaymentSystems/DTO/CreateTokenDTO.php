<?php

namespace App\Services\PaymentSystems\DTO;

class CreateTokenDTO
{
    public function __construct(
        protected int $cardNumber,
        protected int $month,
        protected int $year,
        protected int $cvc,
    ) {
    }

    public function getCardNumber(): int
    {
        return $this->cardNumber;
    }

    public function getMonth(): int
    {
        return $this->month;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function getCvc(): int
    {
        return $this->cvc;
    }
}
