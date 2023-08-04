<?php

namespace App\Services\Users\Login\Handlers;

use App\Repositories\WhiteList\WhiteListIpRepository;
use App\Services\RequestService;
use App\Services\Users\Login\LoginDTO;
use App\Services\Users\Login\LoginInterface;
use Closure;

class CheckWhiteListIpHandler implements LoginInterface
{

    public function __construct(
        protected WhiteListIpRepository $whiteListIpRepository,
        protected RequestService $requestService
    ) {
    }

    public function handle(LoginDTO $loginDTO, Closure $next): LoginDTO
    {
        $exists = $this->whiteListIpRepository->existByUserIdAndIp(
            $loginDTO->getUser()->getId(),
            $this->requestService->getIp(),
        );

        if ($exists === false) {
            return $loginDTO;
        }

        return $next($loginDTO);
    }
}
