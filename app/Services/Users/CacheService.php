<?php

namespace App\Services\Users;

use Closure;
use Illuminate\Support\Facades\Cache;

class CacheService
{
    public function get(string $key)
    {
        return Cache::get($key);
    }

    public function set(
        string $key,
        mixed $value,
        int|null $time = null
    ): bool {
        return Cache::set($key, $value, $time);
    }
}
