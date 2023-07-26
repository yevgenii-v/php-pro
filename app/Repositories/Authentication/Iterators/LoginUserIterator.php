<?php

namespace App\Repositories\Authentication\Iterators;

use Laravel\Passport\PersonalAccessTokenResult;

class LoginUserIterator
{
    public function __construct(
        protected int $id,
        protected string $email,
        protected PersonalAccessTokenResult $bearerToken,
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

    /**
     * @return PersonalAccessTokenResult
     */
    public function getBearerToken(): PersonalAccessTokenResult
    {
        return $this->bearerToken;
    }
}
