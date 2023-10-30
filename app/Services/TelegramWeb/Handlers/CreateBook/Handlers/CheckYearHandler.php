<?php

namespace App\Services\TelegramWeb\Handlers\CreateBook\Handlers;

use App\Services\TelegramWeb\Handlers\CreateBook\CreateBookHandler;
use App\Services\TelegramWeb\Handlers\CreateBook\CreateBookInterface;
use App\Services\TelegramWeb\Handlers\CreateBook\CreateBookTelegramDTO;
use App\Services\TelegramWeb\Handlers\CreateBook\CreateBookTelegramStorage;
use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class CheckYearHandler implements CreateBookInterface
{
    private const NEXT_MESSAGE = 'Enter your book\'s language:';

    public function __construct(
        protected CreateBookTelegramStorage $storage,
    ) {
    }

    /**
     * @param CreateBookTelegramDTO $DTO
     * @param Closure $next
     * @return CreateBookTelegramDTO
     */
    public function handle(CreateBookTelegramDTO $DTO, Closure $next): CreateBookTelegramDTO
    {
        $isYearNotExists = $this->storage->isYearNotExists(
            $DTO->getSenderId()
        );

        if ($isYearNotExists === true) {
            $this->storage->setYear(
                $DTO->getSenderId(),
                $DTO->getArgument(),
            );

            $DTO->setMessage(self::NEXT_MESSAGE);
            return $DTO;
        }

        $DTO->setYear(
            $this->storage->getYear(
                $DTO->getSenderId(),
            )
        );

        return $next($DTO);
    }
}
