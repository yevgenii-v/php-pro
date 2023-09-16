<?php

namespace App\Services;

use App\Repositories\Categories\CategoryRepository;
use App\Services\Users\CacheService;
use Illuminate\Support\Collection;

class CategoryWithCacheService
{
    public const SECONDS = 20;

    public function __construct(
        protected CategoryRepository $categoryRepository,
        protected CacheService $cacheService,
    ) {
    }

    /**
     * @return Collection
     */
    public function getCategories(): Collection
    {
        $cachedData = $this->cacheService->get('categories');

        if ($cachedData === null) {
            $query = $this->categoryRepository->index();
            $this->cacheService->set('categories', $query, self::SECONDS);
            return $query;
        }

        return $cachedData;
    }
}
