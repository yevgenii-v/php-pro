<?php

namespace App\Services;

class RequestService
{
    public function getIp(): ?string
    {
        return request()->ip();
    }
}
