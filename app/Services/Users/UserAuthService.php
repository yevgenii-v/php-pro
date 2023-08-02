<?php

namespace App\Services\Users;

use Laravel\Passport\PersonalAccessTokenResult;
use Laravel\Passport\Token;
use Laravel\Passport\TransientToken;

class UserAuthService
{
    public function getUserId(): int
    {
        return auth()->id();
    }

    public function isCorrectUserData(array $data): bool
    {
        if (auth()->attempt($data) === false) {
            return false;
        }

        return true;
    }

    public function createUserToken(): PersonalAccessTokenResult
    {
        return auth()->user()->createToken(config('app.name'));
    }

    public function getUserToken(): Token|TransientToken|null
    {
        return auth()->user()->token();
    }
}
