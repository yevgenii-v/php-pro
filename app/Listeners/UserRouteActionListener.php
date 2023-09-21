<?php

namespace App\Listeners;

use App\Events\UserRouteActionEvent;
use App\Services\RouteRedisService;
use App\Services\RedisService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class UserRouteActionListener
{
    /**
     * Create the event listener.
     */
    public function __construct(
        protected RouteRedisService $routeRedisService,
    ) {
    }

    /**
     * Handle the event.
     */
    public function handle(UserRouteActionEvent $event): void
    {
        $singleRouteName = $this->routeRedisService->generateSingleRouteName($event);
        $multiRouteName = $this->routeRedisService->generateMultiRouteName($event);

        if ($this->routeRedisService->getRoute($singleRouteName) === null) {
            $this->routeRedisService->createSingleRouteCounter($singleRouteName);
            $this->routeRedisService->createMultiRouteCounter($multiRouteName);
        }

        $incrSingleRoute = $this->routeRedisService->addIncr($singleRouteName);
        $incrMultiRoute = $this->routeRedisService->addIncr($multiRouteName);

        if (
            $incrSingleRoute > RouteRedisService::SINGLE_ROUTE_COUNT
            && $incrSingleRoute <= RouteRedisService::MULTI_ROUTE_COUNT
        ) {
            Log::info('Single route');
        }

        if ($incrMultiRoute > RouteRedisService::MULTI_ROUTE_COUNT) {
            Log::info('Multiple route');
        }
    }
}
