<?php

namespace App\Repositories\Authors\Iterators;

use ArrayIterator;
use Illuminate\Support\Collection;
use IteratorAggregate;

class AuthorsIterator implements IteratorAggregate
{
    protected array $data = [];

    /**
     * @param Collection $collection
     */
    public function __construct(Collection $collection)
    {
        foreach ($collection as $author) {
            $this->data[] = new AuthorIterator($author);
        }
    }

    /**
     * @param AuthorIterator $authorIterator
     * @return void
     */
    public function add(AuthorIterator $authorIterator): void
    {
        $this->data[] = $authorIterator;
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->data);
    }


    public function getResource(): array
    {
        /** @var AuthorIterator $author */
        return array_map(fn($author) => [
            'id'    => $author->getId(),
            'name'  => $author->getName(),
        ], $this->data);
    }
}
