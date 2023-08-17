<?php

namespace App\Services\PaymentSystems\ConfirmPayment;

class PayerDTO
{
    public function __construct(
        protected string $name,
        protected ?string $email,
        protected ?string $phone,
        protected ?string $ip,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }
}
