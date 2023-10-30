<?php

namespace App\Services\TelegramWeb\Handlers\UpdateBook\Handlers;

use App\Repositories\Books\BookRepository;
use App\Repositories\Books\BookUpdateDTO;
use App\Repositories\Books\Iterators\BookWithoutJoinsIterator;
use App\Services\TelegramWeb\Handlers\UpdateBook\UpdateBookInterface;
use App\Services\TelegramWeb\Handlers\UpdateBook\UpdateBookTelegramDTO;
use Closure;

class BookUpdatingHandler implements UpdateBookInterface
{
    public function __construct(
        protected BookRepository $bookRepository,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function handle(UpdateBookTelegramDTO $DTO, Closure $next): UpdateBookTelegramDTO
    {
        $bookUpdateDTO = new BookUpdateDTO(
            $DTO->getId(),
            $DTO->getName(),
            $DTO->getYear(),
            $DTO->getLang(),
            $DTO->getPages(),
            $DTO->getCategoryId(),
        );

        $this->bookRepository->update($bookUpdateDTO);
        $book = $this->bookRepository->getByIdNoCatName(
            $DTO->getId()
        );

        /** @var BookWithoutJoinsIterator $book */

        $result = 'Updated book:' . PHP_EOL;

        $result .= 'id: ' . $book->getId() . PHP_EOL;
        $result .= 'name: ' . $book->getName() . PHP_EOL;
        $result .= 'year: ' . $book->getYear() . PHP_EOL;
        $result .= 'lang: ' . $book->getLang()->value . PHP_EOL;
        $result .= 'pages: ' . $book->getPages() . PHP_EOL;
        $result .= PHP_EOL;

        $DTO->setMessage($result);

        return $DTO;
    }
}
