<?php

namespace App\Repositories\PaymentResults;

use App\Enums\Currency;
use App\Enums\PaymentSystem;
use App\Services\Users\UserAuthService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PaymentResultRepository
{
    public function store(PaymentResultStoreDTO $paymentResultStoreDTO): int
    {
        return DB::table('order_payment_result')
            ->insertGetId([
                'user_id'           => 1,
                'payment_system'    => $paymentResultStoreDTO->getPaymentSystem(),
                'order_id'          => $paymentResultStoreDTO->getOrderId(),
                'payment_id'        => $paymentResultStoreDTO->getPaymentId(),
                'success'           => $paymentResultStoreDTO->getStatus(),
                'amount'            => $paymentResultStoreDTO->getAmount(),
                'currency'          => $paymentResultStoreDTO->getCurrency(),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now()
            ]);
    }
}
