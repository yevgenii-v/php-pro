<?php

namespace App\Repositories\Categories\Iterators;

class CategoryIterator
{
    public function __construct(
        protected int $id,
        protected string $name,
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
}
