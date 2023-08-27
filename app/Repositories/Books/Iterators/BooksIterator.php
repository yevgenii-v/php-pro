<?php

namespace App\Repositories\Books\Iterators;

use App\Repositories\Authors\Iterators\AuthorsIterator;
use App\Repositories\Categories\Iterators\CategoryIterator;
use ArrayIterator;
use Illuminate\Support\Collection;
use IteratorAggregate;

class BooksIterator implements IteratorAggregate
{

    protected array $data = [];

    public function __construct(Collection $collection)
    {
        $tmpData = [];
        foreach ($collection as $item) {
            if (key_exists($item->id, $tmpData) === false) {
                $tmpData[$item->id] = $item;
                $tmpData[$item->id]->authors = collect();
                $tmpData[$item->id]->category = (object)[
                    'id'    => $item->category_id,
                    'name'  => $item->category_name
                ];
            }

            $tmpData[$item->id]->authors->add((object)[
                'id'    => $item->author_id,
                'name'  => $item->author_name,
            ]);
        }

        foreach ($tmpData as $dataItem) {
            $bookIterator = new BookIterator((object)[
                'id'    => $dataItem->id,
                'name'  => $dataItem->name,
                'year'  => $dataItem->year,
                'category' => (object)[
                    'id'    => $dataItem->category_id,
                    'name'  => $dataItem->category_name,
                ],
                'authors' => $dataItem->authors,
                'lang'  => $dataItem->lang,
                'pages'  => $dataItem->pages,
                'created_at'  => $dataItem->created_at,
            ]);

            $this->data[] = $bookIterator;
        }
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->data);
    }
}
