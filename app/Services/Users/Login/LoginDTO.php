<?php

namespace App\Services\Users\Login;

use App\Repositories\Users\Iterators\UserIterator;
use Laravel\Passport\PersonalAccessTokenResult;

class LoginDTO
{

    protected UserIterator $userIterator;
    protected PersonalAccessTokenResult $bearerToken;

    public function __construct(
        protected string $email,
        protected string $password,
    ) {
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return UserIterator
     */
    public function getUser(): UserIterator
    {
        return $this->userIterator;
    }

    /**
     * @param UserIterator $userIterator
     * @return void
     */
    public function setUser(UserIterator $userIterator): void
    {
        $this->userIterator = $userIterator;
    }

    /**
     * @return PersonalAccessTokenResult
     */
    public function getBearerToken(): PersonalAccessTokenResult
    {
        return $this->bearerToken;
    }

    /**
     * @param PersonalAccessTokenResult $bearerToken
     * @return void
     */
    public function setBearerToken(PersonalAccessTokenResult $bearerToken): void
    {
        $this->bearerToken = $bearerToken;
    }
}
