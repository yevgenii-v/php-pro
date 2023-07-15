<?php

namespace App\Repositories\Categories\Iterators;

class CategoryIterator
{
    public function __construct(
        protected int $id,
        protected string|null $name,
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
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }
}
