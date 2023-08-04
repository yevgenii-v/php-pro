<?php

namespace App\Services\Users\Login\Handlers;

use App\Services\Users\Login\LoginDTO;
use App\Services\Users\Login\LoginInterface;
use App\Services\Users\UserAuthService;
use Closure;

class SetPersonalTokenHandler implements LoginInterface
{

    public function __construct(
        protected UserAuthService $userAuthService,
    ) {
    }

    public function handle(LoginDTO $loginDTO, Closure $next): LoginDTO
    {
        $loginDTO->setBearerToken($this->userAuthService->createUserToken());

        return $next($loginDTO);
    }
}
