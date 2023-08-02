<?php

namespace App\Repositories\Users;

use App\Repositories\Users\Iterators\UserIterator;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    protected Builder $query;

    public function __construct()
    {
        $this->query = DB::table('users');
    }

    public function register(RegisterDTO $data): int
    {
        return $this->query->insertGetId([
            'name'          => $data->getName(),
            'email'         => $data->getEmail(),
            'password'      => Hash::make($data->getPassword()),
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);
    }

    public function getUserById(int $id): ?object
    {
        return new UserIterator(
            $this->query
                ->where('id', '=', $id)
                ->first()
        );
    }
}
