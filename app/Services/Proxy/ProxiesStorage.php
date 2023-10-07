<?php

namespace App\Services\Proxy;

use Illuminate\Support\Facades\Redis;

class ProxiesStorage
{
    private const KEY = 'proxies';
    private const MIN_RANGE = 0;
    private const MAX_RANGE = 10;

    public function lpop(): ProxyDTO
    {
        $data = json_decode(Redis::lpop(self::KEY), true);

        return new ProxyDTO(...$data);
    }

    public function rpop(): ProxyDTO
    {
        $data = json_decode(Redis::lpop(self::KEY), true);

        return new ProxyDTO(...$data);
    }

    public function lpush(ProxyDTO $DTO): void
    {
        Redis::lpush(self::KEY, json_encode($DTO));
    }

    public function rpush(ProxyDTO $DTO): void
    {
        Redis::lpush(self::KEY, json_encode($DTO));
    }

    public function lrange()
    {
        return Redis::lrange(self::KEY, self::MIN_RANGE, self::MAX_RANGE);
    }

    public function del(): void
    {
        Redis::del(self::KEY);
    }

    public function llen()
    {
        return Redis::llen(self::KEY);
    }
}
