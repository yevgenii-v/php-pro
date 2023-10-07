<?php

namespace App\Services\WordResult;

use App\Services\WordResult\Handlers\ChangeProxyHandler;
use App\Services\WordResult\Handlers\GetDuckDuckGoResponseHandler;
use App\Services\WordResult\Handlers\WordResultStoreHandler;
use Illuminate\Pipeline\Pipeline;

class WordResultService
{
    protected const HANDLERS = [
        ChangeProxyHandler::class,
        GetDuckDuckGoResponseHandler::class,
        WordResultStoreHandler::class,
    ];

    public function __construct(
        protected Pipeline $pipeline
    ) {
    }

    public function handle(WordResultDTO $DTO): WordResultDTO
    {
        return $this->pipeline
            ->send($DTO)
            ->through(self::HANDLERS)
            ->then(function (WordResultDTO $wordResultDTO) {
                return $wordResultDTO;
            });
    }
}
