<?php

namespace App\Repositories\Authentication\Iterators;

class LoginUserIterator
{
    public function __construct(
        protected int $id,
        protected string $email
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
    public function getEmail(): string
    {
        return $this->email;
    }
}
