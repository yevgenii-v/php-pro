<?php

namespace App\Services\TelegramWeb\Handlers\CreateBook\Handlers;

use App\Services\TelegramWeb\Handlers\CreateBook\CreateBookHandler;
use App\Services\TelegramWeb\Handlers\CreateBook\CreateBookInterface;
use App\Services\TelegramWeb\Handlers\CreateBook\CreateBookTelegramDTO;
use App\Services\TelegramWeb\Handlers\CreateBook\CreateBookTelegramStorage;
use App\Services\TelegramWeb\TelegramIncomeService;
use Closure;
use Illuminate\Support\Facades\Redis;

class PreparationHandler implements CreateBookInterface
{
    private const NEXT_MESSAGE = 'Enter your book\'s name:';

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
        if ($this->isFirstSymbolSlash($DTO->getArgument()) === true) {
            $this->storage->deletePrevBook(
                $DTO->getSenderId(),
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
