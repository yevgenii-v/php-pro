<?php

namespace App\Repositories\Categories\Iterators;

use App\Repositories\Books\Iterators\BooksIterator;
use App\Repositories\Books\Iterators\BooksWJIterator;
use Illuminate\Support\Collection;

class CategoryIterator
{

    protected int $id;
    protected string $name;
    protected BooksWJIterator $books;

    public function __construct(object $data)
    {
        $this->id = $data->id;
        $this->name = $data->name;
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

    public function getBooks(): BooksWJIterator
    {
        return $this->books;
    }

    public function setBooks(BooksWJIterator $booksIterator): void
    {
        $this->books = $booksIterator;
    }
}
