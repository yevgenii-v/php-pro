<?php

namespace App\Repositories\Categories\Iterators;

use App\Repositories\Books\Iterators\BooksWithoutJoinsIterator;

class CategoryIterator
{

    protected int $id;
    protected string $name;
    protected BooksWithoutJoinsIterator $books;

    public function __construct(object $data)
    {
        $this->id       = $data->id;
        $this->name     = $data->name;
        $this->books    = new BooksWithoutJoinsIterator($data->books);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return BooksWithoutJoinsIterator
     */
    public function getBooks(): BooksWithoutJoinsIterator
    {
        return $this->books;
    }
}
