<?php

namespace App\Services\TelegramWeb;

use App\Enums\TelegramCommands;
use App\Services\TelegramWeb\Handlers\CreateBook\CreateBookHandler;
use App\Services\TelegramWeb\Handlers\DeleteBook\DeleteBookHandler;
use App\Services\TelegramWeb\Handlers\DownloadFile\DownloadFileHandler;
use App\Services\TelegramWeb\Handlers\Info\InfoHandler;
use App\Services\TelegramWeb\Handlers\LoadBooks\LoadBooksHandler;
use App\Services\TelegramWeb\Handlers\ShowBook\ShowBookHandler;
use App\Services\TelegramWeb\Handlers\UpdateBook\UpdateBookHandler;

class CommandsFactory
{
    public function handle(TelegramCommands $telegramCommand): CommandsInterface
    {
        return match ($telegramCommand) {
            TelegramCommands::INFO          => app(InfoHandler::class),
            TelegramCommands::LOAD_BOOKS    => app(LoadBooksHandler::class),
            TelegramCommands::DOWNLOAD_FILE => app(DownloadFileHandler::class),
            TelegramCommands::CREATE_BOOK   => app(CreateBookHandler::class),
            TelegramCommands::UPDATE_BOOK   => app(UpdateBookHandler::class),
            TelegramCommands::DELETE_BOOK   => app(DeleteBookHandler::class),
            TelegramCommands::SHOW_BOOK     => app(ShowBookHandler::class),
        };
    }
}
