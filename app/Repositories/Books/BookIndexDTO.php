<?php

namespace App\Repositories\Books;

use App\Enums\Lang;
use Carbon\Carbon;

class BookIndexDTO
{
    public function __construct(
        protected Carbon $startDate,
        protected Carbon $endDate,
        protected int|null $year = null,
        protected Lang|null $lang = null,
    ) {
    }

    /**
     * @return string
     */
    public function getStartDate(): string
    {
        return $this->startDate->format('Y-m-d');
    }

    /**
     * @return string
     */
    public function getEndDate(): string
    {
        return $this->endDate->format('Y-m-d');
    }

    /**
     * @return int|null
     */
    public function getYear(): ?int
    {
        return $this->year;
    }

    /**
     * @return Lang|null
     */
    public function getLang(): ?Lang
    {
        return $this->lang;
    }
}
