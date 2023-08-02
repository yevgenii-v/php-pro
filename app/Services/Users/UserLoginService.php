<?php

namespace App\Services\Users;

use App\Repositories\Users\Iterators\UserIterator;
use App\Repositories\Users\UserRepository;

class UserLoginService
{

    public function __construct(
        protected UserRepository  $authenticationRepository,
        protected UserAuthService $userAuthService,
    ) {
    }

    public function login(array $data): ?UserIterator
    {
        $isUserDataCorrect = $this->userAuthService->isCorrectUserData($data);

        if ($isUserDataCorrect === false) {
            return null;
        }

        $id = $this->userAuthService->getUserId();
        return $this->getUserById($id);
    }

    public function getUserById(int $id): UserIterator
    {
        return $this->authenticationRepository->getUserById($id);
    }
}
