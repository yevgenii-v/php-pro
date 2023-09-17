<?php

namespace App\Services;

use App\Repositories\UserRouteAction\UserRouteActionRepository;
use App\Repositories\UserRouteAction\UserRouteActionStoreDTO;

class UserRouteActionService
{
    public function __construct(
        protected UserRouteActionRepository $userRouteActionRepository
    ) {
    }

    public function store(UserRouteActionStoreDTO $DTO): void
    {
        $this->userRouteActionRepository->store($DTO);
    }
}
