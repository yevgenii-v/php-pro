<?php

namespace App\Repositories\Books\Iterators;

use App\Enums\Lang;
use App\Repositories\Categories\Iterators\CategoryWithoutBooksIterator;
use Carbon\Carbon;

class BookWithoutAuthorsIterator
{
    protected int $id;
    protected string $name;
    protected int $year;
    protected CategoryWithoutBooksIterator $category;
    protected Lang $lang;
    protected int $pages;
    protected Carbon $createdAt;
    protected Carbon $updatedAt;

    /**
     * @param object $data
     */
    public function __construct(object $data)
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->year = $data->year;
        $this->category = new CategoryWithoutBooksIterator($data->category);
        $this->lang = Lang::from($data->lang);
        $this->pages = $data->pages;
        $this->createdAt = new Carbon($data->created_at);
        $this->updatedAt = new Carbon($data->updated_at);
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
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

    /**
     * @return Carbon
     */
    public function getUpdatedAt(): Carbon
    {
        return $this->updatedAt;
    }
}
