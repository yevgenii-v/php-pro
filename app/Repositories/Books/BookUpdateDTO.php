<?php

namespace App\Repositories\Books;

use App\Enums\Lang;

class BookUpdateDTO
{
    public function __construct(
        protected readonly int $id,
        protected string $name,
        protected int $year,
        protected Lang $lang,
        protected int $pages,
        protected int $categoryId,
    ) {
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
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }
}
