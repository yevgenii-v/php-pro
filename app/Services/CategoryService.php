<?php

namespace App\Services;

use App\Repositories\Categories\CategoryRepository;
use App\Repositories\Categories\CategoryStoreDTO;
use App\Repositories\Categories\CategoryUpdateDTO;
use App\Repositories\Categories\Iterators\CategoryIterator;
use Illuminate\Support\Collection;

class CategoryService
{
    public function __construct(
        protected CategoryRepository $categoryRepository,
    ) {
    }

    public function index(): Collection
    {
        return $this->categoryRepository->index();
    }

    public function store(CategoryStoreDTO $data): CategoryIterator
    {
        $categoryId = $this->categoryRepository->store($data);
        return $this->categoryRepository->getById($categoryId);
    }

    public function show(int $id): CategoryIterator
    {
        return $this->categoryRepository->getById($id);
    }

    public function update(CategoryUpdateDTO $data): CategoryIterator
    {
        $this->categoryRepository->update($data);
        return $this->categoryRepository->getById($data->getId());
    }

    public function destroy(int $id): void
    {
        $this->categoryRepository->destroy($id);
    }
}
