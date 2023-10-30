<?php

namespace App\Services\TelegramWeb\Handlers\UpdateBook\Handlers;

use App\Services\TelegramWeb\Handlers\UpdateBook\UpdateBookInterface;
use App\Services\TelegramWeb\Handlers\UpdateBook\UpdateBookTelegramDTO;
use App\Services\TelegramWeb\Handlers\UpdateBook\UpdateBookTelegramStorage;
use Closure;

class CheckYearHandler implements UpdateBookInterface
{
    private const NEXT_MESSAGE = 'Enter new lang for book:';

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
        $isYearNotExists = $this->storage->isYearNotExists($DTO->getSenderId());

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
                $DTO->getSenderId()
            )
        );

        return $next($DTO);
    }
}
