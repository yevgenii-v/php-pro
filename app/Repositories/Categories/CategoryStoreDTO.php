<?php

namespace App\Repositories\Categories;

use Carbon\Carbon;

class CategoryStoreDTO
{
    public function __construct(
        protected string $name,
    ) {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
