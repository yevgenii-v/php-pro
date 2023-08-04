<?php

namespace App\Services\Users\Login\Handlers;

use App\Repositories\LastLoginData\LastLoginDataRepository;
use App\Services\RequestService;
use App\Services\Users\Login\LoginDTO;
use App\Services\Users\Login\LoginInterface;
use Closure;

class SetLastLoginDataHandler implements LoginInterface
{

    public function __construct(
        protected LastLoginDataRepository $lastLoginDataRepository,
        protected RequestService $requestService,
    ) {
    }

    public function handle(LoginDTO $loginDTO, Closure $next): LoginDTO
    {
        $this->lastLoginDataRepository->store(
            $loginDTO->getUser()->getId(),
            $this->requestService->getIp(),
        );

        return $next($loginDTO);
    }
}
