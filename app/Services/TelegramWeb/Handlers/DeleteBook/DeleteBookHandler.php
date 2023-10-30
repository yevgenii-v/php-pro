<?php

namespace App\Services\TelegramWeb\Handlers\DeleteBook;

use App\Repositories\Books\BookRepository;
use App\Services\TelegramWeb\CommandsInterface;
use App\Services\TelegramWeb\TelegramIncomeService;

class DeleteBookHandler implements CommandsInterface
{
    public function __construct(
        protected BookRepository $bookRepository,
    ) {
    }

    /**
     * @param string $arguments
     * @param int $senderId
     * @return string
     */
    public function handle(string $arguments, int $senderId): string
    {
        $isExists = $this->bookRepository->existsById((int)$arguments);

        if ($isExists === false & str_starts_with($arguments, TelegramIncomeService::COMMAND_SLASH) === false) {
            return 'Invalid id';
        }

        if ($isExists === true) {
            $this->bookRepository->destroy((int)$arguments);
            return 'Book deleted successfully.';
        }

        return 'Enter Book ID for delete';
    }
}
