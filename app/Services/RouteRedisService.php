<?php

namespace App\Services;

use App\Events\UserRouteActionEvent;
use Illuminate\Support\Facades\Redis;

class RouteRedisService
{
    public const SINGLE_ROUTE_COUNT = 10;
    public const MULTI_ROUTE_COUNT = 30;
    public const ZERO_COUNTER = 0;
    public const EXPIRE_TIME = 60;
    public const INCR_COUNT = 1;

    /**
     * @param UserRouteActionEvent $event
     * @return string
     */
    public function generateSingleRouteName(UserRouteActionEvent $event): string
    {
        return $event->userRouteActionStoreDTO->getUserId() . '_' . $event->userRouteActionStoreDTO->getRoute();
    }

    /**
     * @param UserRouteActionEvent $event
     * @return string
     */
    public function generateMultiRouteName(UserRouteActionEvent $event): string
    {
        return $event->userRouteActionStoreDTO->getRoute();
    }

    /**
     * @param string $route
     * @return string|null
     */
    public function getRoute(string $route): ?string
    {
        return Redis::get($route);
    }

    /**
     * @param string $route
     * @return mixed
     */
    public function createSingleRouteCounter(string $route): string
    {
        return Redis::set($route, self::ZERO_COUNTER, 'EX', self::EXPIRE_TIME);
    }

    /**
     * @param string $route
     * @return mixed
     */
    public function createMultiRouteCounter(string $route): string
    {
        return Redis::set($route, self::ZERO_COUNTER, 'EX', self::EXPIRE_TIME);
    }

    /**
     * @param string $route
     * @return mixed
     */
    public function addIncr(string $route)
    {
        return Redis::incr($route, self::INCR_COUNT);
    }
}
