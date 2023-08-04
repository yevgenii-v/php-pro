<?php

namespace App\Services\Users\Login\Handlers;

use App\Services\Users\Login\LoginDTO;
use App\Services\Users\Login\LoginInterface;
use App\Services\Users\UserAuthService;
use Closure;

class CheckValidDataHandler implements LoginInterface
{

    public function __construct(
        protected UserAuthService $userAuthService,
    ) {
    }

    public function handle(LoginDTO $loginDTO, Closure $next): LoginDTO
    {
        $data = [
            'email' => $loginDTO->getEmail(),
            'password' => $loginDTO->getPassword(),
        ];

        if ($this->userAuthService->isCorrectUserData($data) === false) {
            return $loginDTO;
        }

        return $next($loginDTO);
    }
}
