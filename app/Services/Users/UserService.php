<?php

namespace App\Services\Users;

use App\Repositories\Users\Iterators\UserIterator;
use App\Repositories\Users\UserRepository;

class UserService
{

    public function __construct(
        protected UserRepository  $authenticationRepository,
    ) {
    }

    public function getById(int $id): UserIterator
    {
        return $this->authenticationRepository->getUserById($id);
    }
}
