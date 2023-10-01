<?php

namespace App\Repositories\Categories;

use App\Models\Category;
use App\Repositories\Books\Iterators\BooksIterator;
use App\Repositories\Books\Iterators\BooksWithoutJoinsIterator;
use App\Repositories\Categories\Iterators\CategoryIterator;
use App\Repositories\Categories\Iterators\CategoryWithBooksIterator;
use App\Repositories\Categories\Iterators\CategoryWithoutBooksIterator;
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

    /**
     * @return Collection
     */
    public function index(): Collection
    {
        $collection = $this->categories->get();

        return $collection->map(function (object $item) {
            return new CategoryWithoutBooksIterator($item);
        });
    }

    /**
     * @param CategoryStoreDTO $data
     * @return int
     */
    public function store(CategoryStoreDTO $data): int
    {
        return $this->categories->insertGetId([
            'name'          => $data->getName(),
            'created_at'    => Carbon::now()->timezone('Europe/Kyiv'),
            'updated_at'    => Carbon::now()->timezone('Europe/Kyiv'),
        ]);
    }

    /**
     * @param CategoryUpdateDTO $data
     * @return bool
     */
    public function update(CategoryUpdateDTO $data): bool
    {
        return $this->categories
            ->where('id', '=', $data->getId())
            ->update([
                'name' => $data->getName(),
                'updated_at' => Carbon::now()->timezone('Europe/Kyiv'),
            ]);
    }

    /**
     * @param int $id
     * @return void
     */
    public function destroy(int $id): void
    {
        $this->categories->where('id', '=', $id)->delete();
    }

    /**
     * @param int $id
     * @return CategoryWithoutBooksIterator
     */
    public function getById(int $id): CategoryWithoutBooksIterator
    {
        $collection = $this->categories
            ->where('id', '=', $id)
            ->first();

        return new CategoryWithoutBooksIterator($collection);
    }

    /**
     * @param int $id
     * @return CategoryWithBooksIterator
     */
    public function getByIdIterator(int $id): CategoryWithBooksIterator
    {

        $result = $this->categories
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

        return new CategoryWithBooksIterator($result);
    }

    /**
     * @param int $id
     * @return Category
     */
    public function getByIdModel(int $id): Category
    {
        return Category::query()
            ->with('books', function ($books) {
                return $books->limit(10);
            })
            ->whereId($id)
            ->first();
    }

    /**
     * @param string $name
     * @return bool
     */
    public function isExistsByName(string $name): bool
    {
        return $this->categories
            ->where('name', '=', $name)
            ->exists();
    }
}
