<?php

namespace App\Repositories\Books\Iterators;

use App\Repositories\Categories\Iterators\CategoryWithoutBooksIterator;
use ArrayIterator;
use Illuminate\Support\Collection;
use IteratorAggregate;

class BooksWithoutAuthorsIterator implements IteratorAggregate
{
    protected array $data = [];

    public function __construct(Collection $collection)
    {
        foreach ($collection as $item) {
            $this->data[] = new BookWithoutAuthorsIterator(
                (object)[
                    'id'            => $item->id,
                    'name'          => $item->name,
                    'year'          => $item->year,
                    'category'      => (object)[
                        'id'        => $item->category_id,
                        'name'      => $item->category_name,
                    ],
                    'lang'          => $item->lang,
                    'pages'         => $item->pages,
                    'created_at'    => $item->created_at,
                ]
            );
        }
    }

    public function add(BookWithoutAuthorsIterator $authorIterator): void
    {
        $this->data[] = $authorIterator;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->data);
    }

    public function getResource(): array
    {
        /** @var BookWithoutAuthorsIterator $book */
        return array_map(fn($book) => [
            'id'            => $book->getId(),
            'name'          => $book->getName(),
            'year'          => $book->getYear(),
            'category'      => new CategoryWithoutBooksIterator($book->getCategory()),
            'lang'          => $book->getLang(),
            'pages'         => $book->getPages(),
            'createdAt'    => $book->getCreatedAt(),
        ], $this->data);
    }
}
