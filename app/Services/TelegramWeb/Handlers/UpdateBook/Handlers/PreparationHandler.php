<?php

namespace App\Services\TelegramWeb\Handlers\UpdateBook\Handlers;

use App\Services\TelegramWeb\Handlers\UpdateBook\UpdateBookInterface;
use App\Services\TelegramWeb\Handlers\UpdateBook\UpdateBookTelegramDTO;
use App\Services\TelegramWeb\Handlers\UpdateBook\UpdateBookTelegramStorage;
use App\Services\TelegramWeb\TelegramIncomeService;
use Closure;

class PreparationHandler implements UpdateBookInterface
{
    private const NEXT_MESSAGE = 'Enter your book\'s id for update:';

    public function __construct(
        protected UpdateBookTelegramStorage $storage,
    ) {
    }

    public function handle(UpdateBookTelegramDTO $DTO, Closure $next): UpdateBookTelegramDTO
    {
        if ($this->isFirstSymbolSlash($DTO->getArgument()) === true) {
            $this->storage->deletePrevBook(
                $DTO->getSenderId()
            );

            $DTO->setMessage(self::NEXT_MESSAGE);
            return $DTO;
        }

        return $next($DTO);
    }

    protected function isFirstSymbolSlash(string $argument): bool
    {
        return str_starts_with($argument, TelegramIncomeService::COMMAND_SLASH);
    }
}
