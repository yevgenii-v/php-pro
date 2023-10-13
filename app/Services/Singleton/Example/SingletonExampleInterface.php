<?php

namespace App\Services\Singleton\Example;

use Closure;

interface SingletonExampleInterface
{
    /**
     * @param SendDataDTO $DTO
     * @param Closure $next
     * @return SendDataDTO
     */
    public function handle(SendDataDTO $DTO, Closure $next): SendDataDTO;
}
