<?php

namespace App\Repositories\Categories\Iterators;

use App\Repositories\Authors\Iterators\AuthorsIterator;
use App\Repositories\Books\Iterators\BookIterator;
use App\Repositories\Books\Iterators\BooksWithoutJoinsIterator;
use App\Repositories\Books\Iterators\BookWithoutJoinsIterator;
use ArrayIterator;
use Illuminate\Support\Collection;
use IteratorAggregate;

class CategoryWithBooksIterator implements IteratorAggregate
{

    protected array $data = [];

    public function __construct(Collection $collection)
    {
        $tmpData = [];
        foreach ($collection as $item) {
            if (key_exists($item->category_id, $tmpData) === false) {
                $tmpData[$item->category_id] = $item;
                $tmpData[$item->category_id]->books = collect();
            }

            $tmpData[$item->category_id]->books->push((object)[
                    'id' => $item->id,
                    'name' => $item->name,
                    'year' => $item->year,
                    'lang' => $item->lang,
                    'pages' => $item->pages,
                    'created_at' => $item->created_at,
                ]);
        }

        foreach ($tmpData as $dataItem) {
            $this->data[] = new CategoryIterator((object)[
                'id'        => $dataItem->category_id,
                'name'      => $dataItem->category_name,
                'books'     => $dataItem->books,
            ]);
        }
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->data);
    }
}
