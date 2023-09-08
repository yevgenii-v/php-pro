<?php

namespace App\Repositories\PaymentResults;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use YevgeniiV\PsPackage\Enums\Status;
use YevgeniiV\PsPackage\PaymentSystems\DTO\PaymentInfoDTO;

class PaymentResultRepository
{
    public function store(PaymentInfoDTO $paymentInfoDTO): int
    {
        return DB::table('order_payment_result')
            ->insertGetId([
                'user_id'           => 1,
                'payment_system'    => $paymentInfoDTO->getPaymentSystem()->value,
                'order_id'          => $paymentInfoDTO->getOrderId(),
                'payment_id'        => $paymentInfoDTO->getPaymentId(),
                'success'           => $paymentInfoDTO->getStatus() === Status::SUCCESS,
                'amount'            => $paymentInfoDTO->getAmount(),
                'currency'          => $paymentInfoDTO->getCurrency()->value,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now()
            ]);
    }
}
