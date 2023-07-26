<?php

namespace App\Repositories\Authentication;

use App\Repositories\Authentication\Iterators\RegisteredUserIterator;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthenticationRepository
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

    public function getUserById(int $id): RegisteredUserIterator
    {
        return new RegisteredUserIterator(
            $this->query->where('id', '=', $id)->first()
        );
    }
}
