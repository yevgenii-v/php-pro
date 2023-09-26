<?php

namespace App\Services\Categories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class AllCategoriesStorage
{
    private const KEY = 'categories';
    private const SECONDS = 20;

    public function get()
    {
        return Cache::get(self::KEY);
    }

    public function set(Collection $collection): bool
    {
        return Cache::set(self::KEY, $collection, self::SECONDS);
    }
}
