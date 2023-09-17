<?php

namespace App\Repositories\Authors\Iterators;

class AuthorIterator
{
    protected int $id;
    protected string $name;

    public function __construct(object $data)
    {
        $this->id   = $data->id;
        $this->name = $data->name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
