<?php

namespace App\Services\TelegramWeb\Handlers\UpdateBook;

use App\Services\TelegramWeb\CommandsInterface;
use App\Services\TelegramWeb\Handlers\UpdateBook\Handlers\BookUpdatingHandler;
use App\Services\TelegramWeb\Handlers\UpdateBook\Handlers\CheckCategoryIdHandler;
use App\Services\TelegramWeb\Handlers\UpdateBook\Handlers\CheckIdHandler;
use App\Services\TelegramWeb\Handlers\UpdateBook\Handlers\CheckLangHandler;
use App\Services\TelegramWeb\Handlers\UpdateBook\Handlers\CheckNameHandler;
use App\Services\TelegramWeb\Handlers\UpdateBook\Handlers\CheckPagesHandler;
use App\Services\TelegramWeb\Handlers\UpdateBook\Handlers\CheckYearHandler;
use App\Services\TelegramWeb\Handlers\UpdateBook\Handlers\PreparationHandler;
use Illuminate\Pipeline\Pipeline;

class UpdateBookHandler implements CommandsInterface
{
    public const HANDLER = [
        PreparationHandler::class,
        CheckIdHandler::class,
        CheckNameHandler::class,
        CheckYearHandler::class,
        CheckLangHandler::class,
        CheckPagesHandler::class,
        CheckCategoryIdHandler::class,
        BookUpdatingHandler::class,
    ];

    public function __construct(
        protected Pipeline $pipeline,
    ) {
    }

    /**
     * @param string $arguments
     * @param int $senderId
     * @return string
     */
    public function handle(string $arguments, int $senderId): string
    {
        $DTO = new UpdateBookTelegramDTO($arguments, $senderId);

        /** @var UpdateBookTelegramDTO $result */
        $result = $this->pipeline
            ->send($DTO)
            ->through(self::HANDLER)
            ->then(function (UpdateBookTelegramDTO $DTO) {
                return $DTO;
            });

        return $result->getMessage();
    }
}
