<?php

namespace App\Services\TelegramWeb\Handlers\CreateBook\Handlers;

use App\Services\TelegramWeb\Handlers\CreateBook\CreateBookHandler;
use App\Services\TelegramWeb\Handlers\CreateBook\CreateBookInterface;
use App\Services\TelegramWeb\Handlers\CreateBook\CreateBookTelegramDTO;
use App\Services\TelegramWeb\Handlers\CreateBook\CreateBookTelegramStorage;
use Closure;
use Illuminate\Support\Facades\Redis;

class CheckNameHandler implements CreateBookInterface
{
    private const NEXT_MESSAGE = 'Enter your book\'s year:';

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
        $isNameNotExists = $this->storage->isNameNotExists(
            $DTO->getSenderId(),
        );

        if ($isNameNotExists === true) {
            $this->storage->setName(
                $DTO->getSenderId(),
                $DTO->getArgument(),
            );

            $DTO->setMessage(self::NEXT_MESSAGE);
            return $DTO;
        }

        $DTO->setName(
            $this->storage->getName(
                $DTO->getSenderId(),
            )
        );

        return $next($DTO);
    }
}
