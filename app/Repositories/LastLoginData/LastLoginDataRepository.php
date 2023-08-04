<?php

namespace App\Repositories\LastLoginData;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LastLoginDataRepository
{
    public function store(int $userId, string $ip): void
    {
        DB::table('last_login_data')
            ->insert([
                'user_id'       => $userId,
                'ip'            => $ip,
                'created_at'    => Carbon::now(),
            ]);
    }
}
