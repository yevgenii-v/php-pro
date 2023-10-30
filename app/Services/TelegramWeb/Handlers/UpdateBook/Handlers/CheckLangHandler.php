<?php

namespace App\Services\TelegramWeb\Handlers\UpdateBook\Handlers;

use App\Services\TelegramWeb\Handlers\UpdateBook\UpdateBookInterface;
use App\Services\TelegramWeb\Handlers\UpdateBook\UpdateBookTelegramDTO;
use App\Services\TelegramWeb\Handlers\UpdateBook\UpdateBookTelegramStorage;
use Closure;

class CheckLangHandler implements UpdateBookInterface
{
    private const NEXT_MESSAGE = 'Enter new number of pages:';

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
        $isLangNotExists = $this->storage->isLangNotExists($DTO->getSenderId());

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
                $DTO->getSenderId(),
            )
        );

        return $next($DTO);
    }
}
