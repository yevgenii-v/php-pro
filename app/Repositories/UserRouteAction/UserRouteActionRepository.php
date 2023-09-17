<?php

namespace App\Repositories\UserRouteAction;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class UserRouteActionRepository
{
    protected Builder $query;
    public function __construct()
    {
        $this->query = DB::table('user_route_action');
    }

    public function store(UserRouteActionStoreDTO $DTO): int
    {
        return $this->query->insertGetId([
            'user_id'       => $DTO->getUserId(),
            'method'        => $DTO->getMethod(),
            'route'         => $DTO->getRoute(),
            'created_at'    => $DTO->getCreatedAt(),
        ]);
    }
}
