<?php

namespace App\Repositories\Categories;

use App\Models\Category;
use App\Repositories\Books\Iterators\BooksWJIterator;
use App\Repositories\Categories\Iterators\CategoryIterator;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CategoryRepository
{

    protected Builder $categories;

    public function __construct()
    {
        $this->categories = DB::table('categories');
    }

    public function index(): Collection
    {
        $collection = $this->categories->get();

        return $collection->map(function (object $item) {
            return new CategoryIterator($item);
        });
    }

    public function store(CategoryStoreDTO $data): int
    {
        return $this->categories->insertGetId([
            'name'          => $data->getName(),
            'created_at'    => Carbon::now()->timezone('Europe/Kyiv'),
            'updated_at'    => Carbon::now()->timezone('Europe/Kyiv'),
        ]);
    }

    public function update(CategoryUpdateDTO $data): bool
    {
        return $this->categories
            ->where('id', '=', $data->getId())
            ->update([
                'name' => $data->getName(),
                'updated_at' => Carbon::now()->timezone('Europe/Kyiv'),
            ]);
    }

    public function destroy(int $id): void
    {
        $this->categories->where('id', '=', $id)->delete();
    }

    public function getById(int $id): CategoryIterator
    {
        $collection = $this->categories
            ->where('id', '=', $id)
            ->first();

        return new CategoryIterator($collection);
    }

    public function getByIdIterator(int $id): CategoryIterator
    {
        $categoryQuery = $this->categories
            ->select([
                'categories.id as category_id',
                'categories.name as category_name',
                'books.id',
                'books.name',
                'books.year',
                'books.lang',
                'books.pages',
                'books.created_at',
                'books.updated_at',
            ])
            ->join('books', 'categories.id', '=', 'books.category_id')
            ->where('categories.id', '=', $id)
            ->limit(10)
            ->get();


            $category = new CategoryIterator((object)[
                'id'    => $categoryQuery->first()->category_id,
                'name'  => $categoryQuery->first()->category_name,
            ]);



        $category->setBooks(new BooksWJIterator($categoryQuery));

        return $category;
    }

    public function getByIdModel(int $id): Category
    {
        return Category::query()
            ->with('books', function ($books) {
                return $books->limit(10);
            })
            ->whereId($id)
            ->first();
    }
}
