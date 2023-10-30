<?php

namespace App\Services\TelegramWeb\Handlers\CreateBook\Handlers;

use App\Services\TelegramWeb\Handlers\CreateBook\CreateBookInterface;
use App\Services\TelegramWeb\Handlers\CreateBook\CreateBookTelegramDTO;
use App\Services\TelegramWeb\Handlers\CreateBook\CreateBookTelegramStorage;
use Closure;

class CheckLangHandler implements CreateBookInterface
{
    private const NEXT_MESSAGE = 'Enter the number of pages of your book:';

    public function __construct(
        protected CreateBookTelegramStorage $storage
    ) {
    }

    /**
     * @param CreateBookTelegramDTO $DTO
     * @param Closure $next
     * @return CreateBookTelegramDTO
     */
    public function handle(CreateBookTelegramDTO $DTO, Closure $next): CreateBookTelegramDTO
    {
        $isLangNotExists = $this->storage->isLangNotExists(
            $DTO->getSenderId(),
        );

        if ($isLangNotExists === true) {
            $this->storage->setLang(
                $DTO->getSenderId(),
                $DTO->getArgument(),
            );

            $DTO->setMessage(self::NEXT_MESSAGE);
            return $DTO;
        }

        $DTO->setLang(
            $this->storage->getLang(
                $DTO->getSenderId()
            ),
        );

        return $next($DTO);
    }
}
