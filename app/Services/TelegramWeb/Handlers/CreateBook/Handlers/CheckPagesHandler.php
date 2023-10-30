<?php

namespace App\Services\TelegramWeb\Handlers\CreateBook\Handlers;

use App\Services\TelegramWeb\Handlers\CreateBook\CreateBookHandler;
use App\Services\TelegramWeb\Handlers\CreateBook\CreateBookInterface;
use App\Services\TelegramWeb\Handlers\CreateBook\CreateBookTelegramDTO;
use App\Services\TelegramWeb\Handlers\CreateBook\CreateBookTelegramStorage;
use Closure;
use Illuminate\Support\Facades\Redis;

class CheckPagesHandler implements CreateBookInterface
{
    private const NEXT_MESSAGE = 'Enter your book\'s category ID:';

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
        $isPagesNotExists = $this->storage->isPagesNotExists(
            $DTO->getSenderId()
        );

        if ($isPagesNotExists === true) {
            $this->storage->setPages(
                $DTO->getSenderId(),
                $DTO->getArgument(),
            );

            $DTO->setMessage(self::NEXT_MESSAGE);
            return $DTO;
        }

        $DTO->setPages(
            $this->storage->getPages(
                $DTO->getSenderId()
            )
        );

        return $next($DTO);
    }
}
