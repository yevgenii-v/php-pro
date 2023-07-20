<?php

namespace App\Services;

use App\Repositories\Books\BookIndexDTO;
use App\Repositories\Books\BookRepository;
use App\Repositories\Books\BookStoreDTO;
use App\Repositories\Books\BookUpdateDTO;
use App\Repositories\Books\Iterators\BookIterator;
use Illuminate\Database\Query\Builder;
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

        $this->getYearQuery($query, $data);

        $this->getLangQuery($query, $data);

        $this->getYearAndLangQuery($query, $data);

        $this->getCreatedAtQuery($query, $data);

        $collection = $query->get();

        return $collection->map(function ($book) {
            return new BookIterator($book);
        });
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


    private function getYearQuery(Builder $query, BookIndexDTO $data): void
    {
        if (is_null($data->getYear()) === false) {
            $query->where('year', '=', $data->getYear())
                ->useIndex('books_year_created_at_index');
        }
    }

    private function getLangQuery(Builder $query, BookIndexDTO $data): void
    {
        if (is_null($data->getLang()) === false) {
            $query->where('lang', '=', $data->getLang())
                ->useIndex('books_lang_created_at_index');
        }
    }

    private function getYearAndLangQuery(Builder $query, BookIndexDTO $data): void
    {
        if (is_null($data->getYear()) === false && is_null($data->getLang()) === false) {
            $query->useIndex('books_year_lang_created_at_index');
        }
    }

    private function getCreatedAtQuery(Builder $query, BookIndexDTO $data): void
    {
        $query->where('books.created_at', '>=', $data->getStartDate())
            ->where('books.created_at', '<=', $data->getEndDate());

        if (is_null($data->getYear()) === true && is_null($data->getLang()) === true) {
            $query->useIndex('books_created_at_index');
        }
    }
}
