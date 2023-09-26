<?php

namespace Tests\Unit\Services;

use App\Repositories\Categories\CategoryRepository;
use App\Services\Categories\AllCategoriesStorage;
use App\Services\Categories\CategoryWithCacheService;
use PHPUnit\Framework\TestCase;

class CategoryWithCacheTest extends TestCase
{
    protected AllCategoriesStorage $allCategoriesStorage;
    protected CategoryRepository $categoryRepository;
    protected CategoryWithCacheService $categoryService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->categoryRepository = $this->createMock(CategoryRepository::class);
        $this->allCategoriesStorage = $this->createMock(AllCategoriesStorage::class);

        $this->categoryService = new CategoryWithCacheService(
            $this->categoryRepository,
            $this->allCategoriesStorage,
        );
    }

    /**
     * A basic unit test example.
     */
    public function testGetCategoryWithCache(): void
    {
        $cacheData = collect();

        $this->allCategoriesStorage
            ->expects(self::once())
            ->method('get')
            ->willReturn($cacheData);

        $this->categoryRepository
            ->expects(self::never())
            ->method('index');

        $this->allCategoriesStorage
            ->expects(self::never())
            ->method('set');

        $result = $this->categoryService->getCategories();

        $this->assertSame($cacheData, $result);
    }

    public function testGetCategoryWithoutCache(): void
    {
        $cacheData = null;

        $this->allCategoriesStorage
            ->expects(self::once())
            ->method('get')
            ->willReturn($cacheData);

        $dbData = collect();

        $this->categoryRepository
            ->expects(self::once())
            ->method('index')
            ->willReturn($dbData);

        $this->allCategoriesStorage
            ->expects(self::once())
            ->method('set')
            ->with($dbData);

        $result = $this->categoryService->getCategories();

        $this->assertSame($dbData, $result);
    }
}
