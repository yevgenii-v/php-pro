<?php

namespace App\Services;

use App\Http\Requests\Authentication\LoginRequest;
use App\Repositories\Authentication\AuthenticationRepository;
use App\Repositories\Authentication\Iterators\RegisteredUserIterator;
use App\Repositories\Authentication\RegisterDTO;

class AuthenticationService
{

    public function __construct(
        protected AuthenticationRepository $authenticationRepository,
    ) {
    }

    public function register(RegisterDTO $data): RegisteredUserIterator
    {
        $userId = $this->authenticationRepository->register($data);

        return $this->authenticationRepository->getUserById($userId);
    }

    public function getBearerToken(LoginRequest $request)
    {
        $data = $request->validated();

        if (auth()->attempt($data) === false) {
            return response(['error' => 'Credentials do not match.']);
        }

        return $this->createUserToken();
    }

    public function getUserById(int $id): RegisteredUserIterator
    {
        return $this->authenticationRepository->getUserById($id);
    }

    protected function createUserToken()
    {
        return auth()->user()->createToken(config('app.name'));
    }
}
