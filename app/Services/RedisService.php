<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;

class RedisService
{
    public function get(string $key)
    {
        return Redis::get($key);
    }

    public function set(string $key, string $value, int $seconds)
    {
        return Redis::set($key, $value, 'EX', $seconds);
    }

    public function incr(string $key)
    {
        return Redis::incr($key);
    }
}
