<?php

namespace App\Services\TelegramWeb\Handlers\CreateBook\Handlers;

use App\Repositories\Books\BookStoreDTO;
use App\Services\Books\BookService;
use App\Services\TelegramWeb\Handlers\CreateBook\CreateBookInterface;
use App\Services\TelegramWeb\Handlers\CreateBook\CreateBookTelegramDTO;
use Closure;

class BookCreationHandler implements CreateBookInterface
{
    public function __construct(
        protected BookService $bookService,
    ) {
    }

    /**
     * @param CreateBookTelegramDTO $DTO
     * @param Closure $next
     * @return CreateBookTelegramDTO
     */
    public function handle(CreateBookTelegramDTO $DTO, Closure $next): CreateBookTelegramDTO
    {
        $bookStoreDTO = new BookStoreDTO(
            $DTO->getName(),
            $DTO->getYear(),
            $DTO->getLang(),
            $DTO->getPages(),
            $DTO->getCategoryId(),
        );

        $book = $this->bookService->store($bookStoreDTO);

        $result = 'Created book:' . PHP_EOL;
        $result .= 'id: ' . $book->getId() . PHP_EOL;
        $result .= 'name: ' . $book->getName() . PHP_EOL;
        $result .= 'year: ' . $book->getYear() . PHP_EOL;
        $result .= 'category: ' . $book->getCategory()->getName() . PHP_EOL;
        $result .= 'lang: ' . $book->getLang()->value . PHP_EOL;
        $result .= 'pages: ' . $book->getPages() . PHP_EOL;
        $result .= PHP_EOL;

        $DTO->setMessage($result);

        return $DTO;
    }
}
