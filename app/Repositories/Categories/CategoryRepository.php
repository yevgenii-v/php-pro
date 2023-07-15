<?php

namespace App\Repositories\Categories;

use App\Repositories\Categories\Iterators\CategoryIterator;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CategoryRepository
{
    public function index(): Collection
    {
        $collection = DB::table('categories')->get();

        return $collection->map(function (object $item) {
            return new CategoryIterator($item->id, $item->name);
        });
    }

    public function store(CategoryStoreDTO $data): int
    {
        return DB::table('categories')->insertGetId([
            'name'          => $data->getName(),
            'created_at'    => Carbon::now()->timezone('Europe/Kyiv'),
            'updated_at'    => Carbon::now()->timezone('Europe/Kyiv'),
        ]);
    }

    public function update(CategoryUpdateDTO $data): bool
    {
        return DB::table('categories')
            ->where('id', '=', $data->getId())
            ->update([
                'name' => $data->getName(),
                'updated_at' => Carbon::now()->timezone('Europe/Kyiv'),
            ]);
    }

    public function destroy(int $id): void
    {
        DB::table('categories')->where('id', '=', $id)->delete();
    }

    public function getById(int $id): CategoryIterator
    {
        $collection = DB::table('categories')
            ->where('id', '=', $id)
            ->first();

        return new CategoryIterator($collection->id, $collection->name);
    }
}
