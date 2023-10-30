<?php

namespace App\Services\TelegramWeb\Handlers\UpdateBook\Handlers;

use App\Services\TelegramWeb\Handlers\UpdateBook\UpdateBookInterface;
use App\Services\TelegramWeb\Handlers\UpdateBook\UpdateBookTelegramDTO;
use App\Services\TelegramWeb\Handlers\UpdateBook\UpdateBookTelegramStorage;
use Closure;

class CheckNameHandler implements UpdateBookInterface
{
    private const NEXT_MESSAGE = 'Enter new year for book:';

    public function __construct(
        protected UpdateBookTelegramStorage $storage,
    ) {
    }
    /**
     * @param UpdateBookTelegramDTO $DTO
     * @param Closure $next
     * @return UpdateBookTelegramDTO
     */
    public function handle(UpdateBookTelegramDTO $DTO, Closure $next): UpdateBookTelegramDTO
    {
        $isNameNotExists = $this->storage->isNameNotExists($DTO->getSenderId());

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
                $DTO->getSenderId()
            )
        );

        return $next($DTO);
    }
}
