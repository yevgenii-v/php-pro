<?php

namespace App\Services\WordResult\Handlers;

use App\Repositories\WordResultRepository\WordResultRepository;
use App\Services\WordResult\WordResultDTO;
use App\Services\WordResult\WordResultInterface;
use Closure;

class WordResultStoreHandler implements WordResultInterface
{
    public function __construct(
        protected WordResultRepository $wordResultRepository,
    ) {
    }

    /**
     * @param WordResultDTO $DTO
     * @param Closure $next
     * @return WordResultDTO
     */
    public function handle(WordResultDTO $DTO, Closure $next): WordResultDTO
    {
        $this->wordResultRepository->insert(
            $DTO->getWordResultStoreDTO()
        );

        return $next($DTO);
    }
}
