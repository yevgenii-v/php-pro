<?php

namespace App\Services;

use App\Repositories\Books\BookIndexDTO;
use App\Repositories\Books\BookRepository;
use App\Repositories\Books\BookStoreDTO;
use App\Repositories\Books\BookUpdateDTO;
use App\Repositories\Books\Iterators\BookIterator;
use App\Repositories\Books\Iterators\BooksIterator;
use App\Repositories\Categories\Iterators\CategoryIterator;
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

        if (is_null($data->getYear()) === false) {
            $this->bookRepository->filterByYear($data->getYear());
            $this->bookRepository->useYearCreatedAtIndex();
        }

        if (is_null($data->getLang()) === false) {
            $this->bookRepository->filterByLang($data->getLang());
            $this->bookRepository->useLangCreatedAtIndex();
        }

        $this->bookRepository->filterByCreatedAt($data->getStartDate(), $data->getEndDate());

        if (is_null($data->getYear()) === false && is_null($data->getLang()) === false) {
            $this->bookRepository->useYearLangCreatedAtIndex();
        }

        if (is_null($data->getYear()) === true && is_null($data->getLang()) === true) {
            $this->bookRepository->useCreatedAtIndex();
        }

        $collection = $query->get();

        return $collection->map(function ($book) {
            $bookIterator = new BookIterator($book);
            $bookIterator->setCategory(new CategoryIterator((object)[
                'id'    => $book->category_id,
                'name'  => $book->category_name,
            ]));

            return $bookIterator;
        });
    }

    public function getDataByIterator(int $lastId): BooksIterator
    {
        return $this->bookRepository->getDataByIterator($lastId);
    }

    public function getDataByModel(int $lastId): Collection
    {
        return $this->bookRepository->getDataByModel($lastId);
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
        $this->bookRepository->update($data);
        return $this->bookRepository->getById($data->getId());
    }

    public function destroy(int $id): void
    {
        $this->bookRepository->destroy($id);
    }
}
