<?php

namespace App\Services\TelegramWeb\Handlers\CreateBook;

use App\Services\TelegramWeb\CommandsInterface;
use App\Services\TelegramWeb\Handlers\CreateBook\Handlers\BookCreationHandler;
use App\Services\TelegramWeb\Handlers\CreateBook\Handlers\CheckCategoryIdHandler;
use App\Services\TelegramWeb\Handlers\CreateBook\Handlers\CheckLangHandler;
use App\Services\TelegramWeb\Handlers\CreateBook\Handlers\CheckNameHandler;
use App\Services\TelegramWeb\Handlers\CreateBook\Handlers\CheckPagesHandler;
use App\Services\TelegramWeb\Handlers\CreateBook\Handlers\CheckYearHandler;
use App\Services\TelegramWeb\Handlers\CreateBook\Handlers\PreparationHandler;
use Illuminate\Pipeline\Pipeline;

class CreateBookHandler implements CommandsInterface
{
    public const HANDLERS = [
        PreparationHandler::class,
        CheckNameHandler::class,
        CheckYearHandler::class,
        CheckLangHandler::class,
        CheckPagesHandler::class,
        CheckCategoryIdHandler::class,
        BookCreationHandler::class,
    ];

    public function __construct(
        protected Pipeline $pipeline
    ) {
    }

    public function handle(string $arguments, int $senderId): string
    {
        $DTO = new CreateBookTelegramDTO($arguments, $senderId);

        /** @var CreateBookTelegramDTO $result */
        $result = $this->pipeline
            ->send($DTO)
            ->through(self::HANDLERS)
            ->then(function (CreateBookTelegramDTO $DTO) {
                    return $DTO;
            });

        return $result->getMessage();
    }
}
