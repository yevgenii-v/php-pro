<?php

namespace App\Repositories\Books;

class BookStoreDTO
{
    public function __construct(
        protected string $name,
        protected int $year,
        protected string $lang,
        protected int $pages,
    ) {
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
     * @return string
     */
    public function getLang(): string
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
}
