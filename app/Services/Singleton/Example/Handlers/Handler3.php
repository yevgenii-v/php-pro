<?php

namespace App\Services\Singleton\Example\Handlers;

use App\Services\Singleton\Example\SaveDataStorage;
use App\Services\Singleton\Example\SendDataDTO;
use App\Services\Singleton\Example\SingletonExampleInterface;
use Closure;

class Handler3 implements SingletonExampleInterface
{
//    public function __construct(
//        protected SaveDataStorage $saveDataStorage,
//    ) {
//    }

    /**
     * @param SendDataDTO $DTO
     * @param Closure $next
     * @return SendDataDTO
     */
    public function handle(SendDataDTO $DTO, Closure $next): SendDataDTO
    {
        echo 'Echo form h3' . PHP_EOL;
//        echo $this->saveDataStorage->getCount() . PHP_EOL;
        echo SaveDataStorage::getInstance()->getCount(). PHP_EOL;
        return $next($DTO);
    }
}
