<?php

namespace App\Services\Books\Storages;

use Illuminate\Support\Facades\Redis;

class BookViewsCounterStorage
{
    private const KEY = 'count_book_views';

    public function get(): string
    {
        return Redis::get(self::KEY);
    }
    public function set(string $value): void
    {
        Redis::set(self::KEY, $value);
    }

    public function exists(): bool
    {
        return Redis::exists(self::KEY);
    }

    public function delete(): void
    {
        Redis::del(self::KEY);
    }
}
