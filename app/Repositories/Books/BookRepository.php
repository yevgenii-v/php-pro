<?php

namespace App\Repositories\Books;

use App\Repositories\Books\Iterators\BookIterator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class BookRepository
{
    public function index(BookIndexDTO $data): Builder
    {
        return DB::table('books')
            ->select([
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
    }

    public function store(BookStoreDTO $data): int
    {
        return DB::table('books')->insertGetId([
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
        return DB::table('books')->where('id', '=', $id)->first();
    }

    public function update(BookUpdateDTO $data): bool
    {
        return DB::table('books')
            ->where('id', '=', $data->getId())
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
        DB::table('books')->where('id', '=', $id)->delete();
    }

    public function getById(int $id): BookIterator
    {
        return new BookIterator(
            DB::table('books')
            ->select([
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
                ->where('books.id', '=', $id)
                ->first()
        );
    }
}
