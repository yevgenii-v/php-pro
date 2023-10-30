<?php

namespace App\Repositories\Books;

use App\Enums\Lang;
use App\Models\Book;
use App\Repositories\Books\Iterators\BooksIterator;
use App\Repositories\Books\Iterators\BooksWithoutAuthorsIterator;
use App\Repositories\Books\Iterators\BooksWithoutJoinsIterator;
use App\Repositories\Books\Iterators\BookWithoutAuthorsIterator;
use App\Repositories\Books\Iterators\BookWithoutJoinsIterator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BookRepository
{
    private Builder $query;

    public function __construct()
    {
        $this->query = DB::table('books');
    }

    public function index(BookIndexDTO $data): Builder
    {
        $this->query->select([
                'books.id',
                'books.name',
                'year',
                'lang',
                'books.pages',
                'books.created_at',
                'category_id',
                'categories.name as category_name'
            ])
            ->join('categories', 'categories.id', '=', 'books.category_id')
            ->orderBy('books.id')
            ->limit(10)
            ->where('books.id', '>', $data->getLastId());

        return $this->query;
    }

    public function getData(int $lastId = 0): BooksWithoutAuthorsIterator
    {
        $bookQuery = $this->query->select([
            'books.id',
            'books.name',
            'year',
            'lang',
            'books.pages',
            'books.created_at',
            'category_id',
            'categories.name as category_name',
        ])
            ->join('categories', 'categories.id', '=', 'books.category_id')
            ->orderBy('books.id')
            ->limit(5)
            ->where('books.id', '>', $lastId)
            ->get();

        return new BooksWithoutAuthorsIterator($bookQuery);
    }

    public function store(BookStoreDTO $data): int
    {
        return $this->query->insertGetId([
            'name'          => $data->getName(),
            'year'          => $data->getYear(),
            'lang'          => $data->getLang(),
            'pages'         => $data->getPages(),
            'category_id'   => $data->getCategoryId(),
            'created_at'    => Carbon::now()->timezone('Europe/Kyiv'),
            'updated_at'    => Carbon::now()->timezone('Europe/Kyiv'),
        ]);
    }

    public function show(int $id): Model|Builder|null
    {
        return $this->query->where('id', '=', $id)->first();
    }

    public function update(BookUpdateDTO $data): bool
    {
        return $this->query
            ->where('books.id', '=', $data->getId())
            ->update([
            'name'          => $data->getName(),
            'year'          => $data->getYear(),
            'lang'          => $data->getLang(),
            'pages'         => $data->getPages(),
            'category_id'   => $data->getCategoryId(),
            'updated_at'    => Carbon::now()->timezone('Europe/Kyiv'),
        ]);
    }

    public function destroy(int $id): void
    {
        $this->query->where('id', '=', $id)->delete();
    }

    public function getByIdWithCatName(int $id): BookWithoutAuthorsIterator
    {
        $bookQuery = $this->query
            ->select([
                'books.id',
                'books.name',
                'year',
                'lang',
                'books.pages',
                'books.created_at',
                'categories.id as category_id',
                'categories.name as category_name'
            ])
            ->where('books.id', '=', $id)
            ->join('categories', 'categories.id', '=', 'books.category_id')
            ->first();

        return new BookWithoutAuthorsIterator((object)[
            'id'            => $bookQuery->book_id,
            'name'          => $bookQuery->name,
            'year'          => $bookQuery->year,
            'category'      => (object)[
                'id'        => $bookQuery->category_id,
                'name'      => $bookQuery->category_name,
            ],
            'lang'          => $bookQuery->lang,
            'pages'         => $bookQuery->pages,
            'created_at'    => $bookQuery->created_at,
        ]);
    }

    public function getByIdNoCatName(int $id): BookWithoutJoinsIterator
    {
        $bookQuery = $this->query
            ->select([
                'books.id',
                'books.name',
                'year',
                'lang',
                'books.pages',
                'books.created_at',
                'category_id',
            ])
            ->where('id', '=', $id)
            ->first();

        return new BookWithoutJoinsIterator((object)[
            'id'            => $bookQuery->id,
            'name'          => $bookQuery->name,
            'year'          => $bookQuery->year,
            'category_id'   => $bookQuery->category_id,
            'lang'          => $bookQuery->lang,
            'pages'         => $bookQuery->pages,
            'created_at'    => $bookQuery->created_at,
        ]);
    }

    public function getDataByIterator(int $lastId = 0): BooksIterator
    {
        $result = $this->query
            ->select([
                'books.id',
                'books.name',
                'year',
                'lang',
                'pages',
                'category_id',
                'categories.name as category_name',
                'books.created_at',
                'books.updated_at',
                'authors.id as author_id',
                'authors.name as author_name',
            ])
            ->leftJoin('categories', 'categories.id', '=', 'books.category_id')
            ->join('author_book', 'books.id', '=', 'author_book.book_id')
            ->join('authors', 'author_book.author_id', '=', 'authors.id')
            ->orderBy('books.id')
            ->where('books.id', '>', $lastId)
            ->get();

        return new BooksIterator($result);
    }

    /**
     * @param int $lastId
     * @return Collection
     */
    public function getDataByModel(int $lastId = 0): Collection
    {
        return Book::query()
            ->with(['authors', 'category'])
            ->where('id', '>', $lastId)
            ->orderBy('id')
            ->limit(2000)
            ->get();
    }

    public function filterByYear(int $year): Builder
    {
        return $this->query->where('year', '=', $year);
    }

    public function filterByLang(Lang $lang): Builder
    {
        return $this->query->where('lang', '=', $lang);
    }

    public function filterByCreatedAt(string $startDate, string $endDate): Builder
    {
        return $this->query->where('books.created_at', '>=', $startDate)
            ->where('books.created_at', '<=', $endDate);
    }

    public function useCreatedAtIndex(): Builder
    {
        return $this->query->whereRaw("books.created_at IS NOT NULL");
    }

    public function useYearCreatedAtIndex(): Builder
    {
        return $this->query->whereRaw("books.year IS NOT NULL AND books.created_at IS NOT NULL");
    }

    public function useLangCreatedAtIndex(): Builder
    {
        return $this->query->whereRaw("books.lang IS NOT NULL AND books.created_at IS NOT NULL");
    }

    public function useYearLangCreatedAtIndex(): Builder
    {
        return $this->query
            ->whereRaw("books.year IS NOT NULL AND books.lang IS NOT NULL AND books.created_at IS NOT NULL");
    }

    /**
     * @param BookStatisticsCounterDTO $dto
     * @return void
     */
    public function storeViewsPerHour(BookStatisticsCounterDTO $dto): void
    {
        DB::table('book_per_hour_statistics')
            ->insert([
                'book_id'       => $dto->getId(),
                'book_views'    => $dto->getCount(),
                'book_comments' => 0,
                'created_at'    => Carbon::now(),
            ]);
    }

    /**
     * @param BookStatisticsCounterDTO $dto
     * @return void
     */
    public function storeCommentsPerHour(BookStatisticsCounterDTO $dto): void
    {
        DB::table('book_per_hour_statistics')
            ->where('book_id', '=', $dto->getId())
            ->update([
                'book_comments' => $dto->getCount(),
                'updated_at' => Carbon::now(),
            ]);
    }

    public function existsById(int $id): bool
    {
        return $this->query->where('id', '=', $id)->exists();
    }
}
