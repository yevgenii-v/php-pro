<?php

namespace App\Services\Categories;

use App\Models\Category;
use App\Repositories\Categories\CategoryRepository;
use App\Repositories\Categories\CategoryStoreDTO;
use App\Repositories\Categories\CategoryUpdateDTO;
use App\Repositories\Categories\Iterators\CategoryWithBooksIterator;
use App\Repositories\Categories\Iterators\CategoryWithoutBooksIterator;
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

    public function store(CategoryStoreDTO $data): CategoryWithoutBooksIterator
    {
        $categoryId = $this->categoryRepository->store($data);
        return $this->categoryRepository->getById($categoryId);
    }

    public function show(int $id): CategoryWithoutBooksIterator
    {
        return $this->categoryRepository->getById($id);
    }

    public function showIterator(int $id): CategoryWithBooksIterator
    {
        return $this->categoryRepository->getByIdIterator($id);
    }

    public function showModel(int $id): Category
    {
        return $this->categoryRepository->getByIdModel($id);
    }

    public function update(CategoryUpdateDTO $data): CategoryWithoutBooksIterator
    {
        $this->categoryRepository->update($data);
        return $this->categoryRepository->getById($data->getId());
    }

    public function destroy(int $id): void
    {
        $this->categoryRepository->destroy($id);
    }
}
