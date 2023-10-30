<?php

namespace App\Services\TelegramWeb\Handlers\ShowBook;

use App\Repositories\Books\BookRepository;
use App\Services\TelegramWeb\CommandsInterface;
use App\Services\TelegramWeb\TelegramIncomeService;
use Exception;

class ShowBookHandler implements CommandsInterface
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
        $exists = $this->bookRepository->existsById((int)$arguments);

        if ($exists === false && str_starts_with($arguments, TelegramIncomeService::COMMAND_SLASH) === false) {
            return 'Invalid ID.';
        }

        if ($exists === false) {
            return 'Enter your book ID';
        }

        try {
            $book = $this->bookRepository->getByIdNoCatName((int)$arguments);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        $result = 'id: ' . $book->getId() . PHP_EOL;
        $result .= 'name: ' . $book->getName() . PHP_EOL;
        $result .= 'year: ' . $book->getYear() . PHP_EOL;
        $result .= 'lang: ' . $book->getLang()->value . PHP_EOL;
        $result .= 'pages: ' . $book->getPages() . PHP_EOL;
        $result .= PHP_EOL;

        return $result;
    }
}
