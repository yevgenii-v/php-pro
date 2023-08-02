<?php

namespace App\Services\Users;

use App\Repositories\Users\UserRepository;
use App\Repositories\Users\Iterators\UserIterator;
use App\Repositories\Users\RegisterDTO;

class UserRegisterService
{

    public function __construct(
        protected UserRepository $authenticationRepository,
    ) {
    }

    public function register(RegisterDTO $data): UserIterator
    {
        $userId = $this->authenticationRepository->register($data);

        return $this->getUserById($userId);
    }

    public function getUserById(int $id): UserIterator
    {
        return $this->authenticationRepository->getUserById($id);
    }
}
