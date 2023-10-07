<?php

namespace App\Services\WordResult\Handlers;

use App\Services\Proxy\ProxiesStorage;
use App\Services\WordResult\WordResultDTO;
use App\Services\WordResult\WordResultInterface;
use Closure;

class ChangeProxyHandler implements WordResultInterface
{
    public function __construct(
        protected ProxiesStorage $proxiesStorage,
    ) {
    }

    /**
     * @param WordResultDTO $DTO
     * @param Closure $next
     * @return WordResultDTO
     */
    public function handle(WordResultDTO $DTO, Closure $next): WordResultDTO
    {
        $proxy = $this->proxiesStorage->lpop();
        $this->proxiesStorage->rpush($proxy);

        $DTO->setProxyDTO($proxy);

        return $next($DTO);
    }
}
