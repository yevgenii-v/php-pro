<?php

namespace App\Repositories\Books\Iterators;

use ArrayIterator;
use Illuminate\Support\Collection;
use IteratorAggregate;

class BooksWithoutJoinsIterator implements IteratorAggregate
{

    protected array $data = [];

    public function __construct(Collection $collection)
    {
        foreach ($collection as $item) {
            $this->data[] = new BookWithoutJoinsIterator($item);
        }
    }

    public function add(BookIterator $authorIterator): void
    {
        $this->data[] = $authorIterator;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->data);
    }

    public function getResource(): array
    {
        /** @var BookIterator $book */
        return array_map(fn($book) => [
            'id'            => $book->getId(),
            'name'          => $book->getName(),
            'year'          => $book->getYear(),
            'lang'          => $book->getLang(),
            'pages'         => $book->getPages(),
            'created_at'    => $book->getCreatedAt(),
        ], $this->data);
    }
}
