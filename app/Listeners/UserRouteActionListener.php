<?php

namespace App\Listeners;

use App\Events\UserRouteActionEvent;
use App\Services\RedisService;
use Illuminate\Support\Facades\Log;

class UserRouteActionListener
{
    /**
     * Create the event listener.
     */
    public function __construct(
        protected RedisService $redisService
    ) {
    }

    /**
     * Handle the event.
     */
    public function handle(UserRouteActionEvent $event): void
    {
        $singleRoute = $event->userRouteActionStoreDTO->getUserId() . '_' . $event->userRouteActionStoreDTO->getRoute();
        $multiRoute = $event->userRouteActionStoreDTO->getUserId();

        if ($this->redisService->get($singleRoute) === null) {
            $this->redisService->set($singleRoute, 0, 60);
            $this->redisService->set($multiRoute, 0, 60);
        }

        $incrSingleRoute = $this->redisService->incr($singleRoute);
        $incrMultiRoute = $this->redisService->incr($multiRoute);

        if ($incrSingleRoute > 10 && $incrSingleRoute < 30) {
            Log::info('Single route');
        }

        if ($incrMultiRoute > 30) {
            Log::info('Multiple route');
        }
    }
}
