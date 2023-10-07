<?php

namespace App\Services\WordResult;

use Closure;

interface WordResultInterface
{
    /**
     * @param WordResultDTO $DTO
     * @param Closure $next
     * @return WordResultDTO
     */
    public function handle(WordResultDTO $DTO, Closure $next): WordResultDTO;
}
