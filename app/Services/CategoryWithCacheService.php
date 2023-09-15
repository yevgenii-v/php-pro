<?php

namespace App\Services;

use App\Repositories\Categories\CategoryRepository;
use App\Services\Users\CacheService;
use Illuminate\Support\Collection;

class CategoryWithCacheService
{
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
        $seconds = 20;
        $cachedData = $this->cacheService->get('categories');

        if ($cachedData === null) {
            $query = $this->categoryRepository->index();
            $this->cacheService->set('categories', $query, $seconds);
            return $query;
        }

        return $cachedData;
    }
}
