<?php

namespace App\Services\Singleton\Example;

use App\Services\Singleton\Example\Handlers\Handler1;
use App\Services\Singleton\Example\Handlers\Handler2;
use App\Services\Singleton\Example\Handlers\Handler3;
use Illuminate\Pipeline\Pipeline;

class SingletonExample
{
    const HANDLERS = [
        Handler1::class,
        Handler2::class,
        Handler3::class,
    ];

    public function __construct(
        protected Pipeline $pipeline,
    ) {
    }

    public function handle(): void
    {
        $DTO = new SendDataDTO();
        $this->pipeline
            ->send($DTO)
            ->through(self::HANDLERS)
            ->then(function (SendDataDTO $DTO) {
                return $DTO;
            });
    }
}
