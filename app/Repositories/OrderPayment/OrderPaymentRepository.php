<?php

namespace App\Repositories\OrderPayment;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderPaymentRepository
{
    public function store(): int
    {
        return DB::table('order_payment')
            ->insertGetId([
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
    }
}
