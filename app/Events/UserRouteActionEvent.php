<?php

namespace App\Events;

use App\Repositories\UserRouteAction\UserRouteActionStoreDTO;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserRouteActionEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public UserRouteActionStoreDTO $userRouteActionStoreDTO
    ) {
    }
}
