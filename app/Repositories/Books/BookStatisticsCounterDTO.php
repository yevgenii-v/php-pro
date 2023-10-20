<?php

namespace App\Repositories\Books;

class BookStatisticsCounterDTO
{
    public function __construct(
        protected int $id,
        protected int $count,
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
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }
}
