<?php

namespace App\Services\TelegramWeb\Handlers\LoadBooks;

use App\Repositories\Books\BookRepository;
use App\Repositories\Books\Iterators\BookIterator;
use App\Services\TelegramWeb\CommandsInterface;

class LoadBooksHandler implements CommandsInterface
{
    public function __construct(
        protected BookRepository $bookRepository,
    ) {
    }

    public function handle(string $arguments, int $senderId): string
    {
        $result = '';
        $books = $this->bookRepository->getData((int)$arguments);

        /** @var BookIterator $book */
        foreach ($books as $book) {
            $result .= 'id:' . $book->getId() . PHP_EOL;
            $result .= 'name:' . $book->getName() . PHP_EOL;
            $result .= 'year:' . $book->getYear() . PHP_EOL;
            $result .= 'lang:' . $book->getLang()->value . PHP_EOL;
            $result .= PHP_EOL . PHP_EOL;
        }
        $result .= 'Enter last Id for load more books';

        return $result;
    }
}
