<?php

namespace App\Repositories\UserRouteAction;

use App\Enums\RequestMethod;
use Carbon\Carbon;

class UserRouteActionStoreDTO
{
    public function __construct(
        protected int $userId,
        protected RequestMethod $method,
        protected string $route,
        protected Carbon $createdAt,
    ) {
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return RequestMethod
     */
    public function getMethod(): RequestMethod
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }
}
