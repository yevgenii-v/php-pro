<?php

namespace App\Services\Users\Login;

use Closure;

interface LoginInterface
{
    public function handle(LoginDTO $loginDTO, Closure $next): LoginDTO;
}
