<?php

namespace App\Repositories\Books\Iterators;

use App\Enums\Lang;
use App\Repositories\Authors\Iterators\AuthorsIterator;
use App\Repositories\Categories\Iterators\CategoryWithoutBooksIterator;
use Carbon\Carbon;

class BookIterator
{
    protected int $id;
    protected string $name;
    protected int $year;
    protected CategoryWithoutBooksIterator $category;
    protected AuthorsIterator $authors;
    protected Lang $lang;
    protected int $pages;
    protected Carbon $createdAt;

    /**
     * @param object $data
     */
    public function __construct(object $data)
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->year = $data->year;
        $this->category = new CategoryWithoutBooksIterator($data->category);
        $this->authors = new AuthorsIterator($data->authors);
        $this->lang = Lang::from($data->lang);
        $this->pages = $data->pages;
        $this->createdAt = new Carbon($data->created_at);
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
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @return Lang
     */
    public function getLang(): Lang
    {
        return $this->lang;
    }

    /**
     * @return int
     */
    public function getPages(): int
    {
        return $this->pages;
    }

    /**
     * @return CategoryWithoutBooksIterator
     */
    public function getCategory(): CategoryWithoutBooksIterator
    {
        return $this->category;
    }

    /**
     * @return AuthorsIterator
     */
    public function getAuthors(): AuthorsIterator
    {
        return $this->authors;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }
}
