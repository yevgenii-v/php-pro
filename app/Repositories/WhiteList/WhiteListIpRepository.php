<?php

namespace App\Repositories\WhiteList;

use Illuminate\Support\Facades\DB;

class WhiteListIpRepository
{
    public function existByUserIdAndIp(int $userId, string $ip): bool
    {
        return DB::table('white_list_ip')
            ->where('user_id', '=', $userId)
            ->where('ip', '=', $ip)
            ->exists();
    }
}
