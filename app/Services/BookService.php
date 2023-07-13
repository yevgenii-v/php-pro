<?php

namespace App\Services;

use App\Repositories\Books\BookIndexDTO;
use App\Repositories\Books\BookRepository;
use App\Repositories\Books\BookStoreDTO;
use App\Repositories\Books\BookUpdateDTO;
use App\Repositories\Books\Iterators\BookIterator;
use Illuminate\Support\Collection;

class BookService
{
    public function __construct(
        protected BookRepository $bookRepository,
    ) {
    }

    public function index(BookIndexDTO $data): Collection
    {
        $query = $this->bookRepository->index($data);
        return $this->bookRepository->getByQuery($query);
    }

    public function store(BookStoreDTO $data): BookIterator
    {
        $bookId = $this->bookRepository->store($data);
        return $this->bookRepository->getById($bookId);
    }

    public function show(int $id): BookIterator
    {
        return $this->bookRepository->getById($id);
    }

    public function update(BookUpdateDTO $data): BookIterator
    {
        $bookId = $this->bookRepository->update($data);
        return $this->bookRepository->getById($bookId);
    }

    public function destroy(int $id): int
    {
        return $this->bookRepository->destroy($id);
    }
}
