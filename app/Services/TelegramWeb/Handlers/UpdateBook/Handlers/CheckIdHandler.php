<?php

namespace App\Services\TelegramWeb\Handlers\UpdateBook\Handlers;

use App\Services\TelegramWeb\Handlers\UpdateBook\UpdateBookInterface;
use App\Services\TelegramWeb\Handlers\UpdateBook\UpdateBookTelegramDTO;
use App\Services\TelegramWeb\Handlers\UpdateBook\UpdateBookTelegramStorage;
use Closure;

class CheckIdHandler implements UpdateBookInterface
{
    private const NEXT_MESSAGE = 'Enter new name for book:';

    public function __construct(
        protected UpdateBookTelegramStorage $storage,
    ) {
    }

    public function handle(UpdateBookTelegramDTO $DTO, Closure $next): UpdateBookTelegramDTO
    {
        $isIdNotExists = $this->storage->isIdNotExists(
            $DTO->getSenderId()
        );

        if ($isIdNotExists === true) {
            $this->storage->setId(
                $DTO->getSenderId(),
                $DTO->getArgument()
            );

            $DTO->setMessage(self::NEXT_MESSAGE);
            return $DTO;
        }

        $DTO->setId(
            $this->storage->getId(
                $DTO->getSenderId()
            )
        );

        return $next($DTO);
    }
}
