<?php

namespace App\Services;

use App\Repositories\OrderPayment\OrderPaymentRepository;

class OrderPaymentService
{

    protected OrderPaymentRepository $orderPaymentRepository;
    public function __construct()
    {
        $this->orderPaymentRepository = new OrderPaymentRepository();
    }

    public function store(): int
    {
        return $this->orderPaymentRepository->store();
    }
}
