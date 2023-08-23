<?php

namespace App\Repositories\Books\Iterators;

use App\Enums\Lang;
use App\Repositories\Authors\Iterators\AuthorsIterator;
use App\Repositories\Categories\Iterators\CategoryIterator;
use Carbon\Carbon;

class BookIterator
{
    protected int $id;
    protected string $name;
    protected int $year;
    protected CategoryIterator $category;
    protected AuthorsIterator $authors;
    protected Lang $lang;
    protected int $pages;
    protected Carbon $createdAt;

    /**
     * @param object $data
     */
    public function __construct(object $data)
    {
        $this->id           = $data->id;
        $this->name         = $data->name;
        $this->year         = $data->year;
        $this->lang         = Lang::from($data->lang);
        $this->pages        = $data->pages;
        $this->createdAt    = new Carbon($data->created_at);
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
     * @return CategoryIterator
     */
    public function getCategory(): CategoryIterator
    {
        return $this->category;
    }

    public function setCategory(CategoryIterator $category): void
    {
        $this->category = $category;
    }

    public function getAuthors(): AuthorsIterator
    {
        return $this->authors;
    }

    public function setAuthors(AuthorsIterator $authors): void
    {
        $this->authors = $authors;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }
}
