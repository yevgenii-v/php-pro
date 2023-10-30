<?php

namespace App\Services\TelegramWeb\Handlers\UpdateBook\Handlers;

use App\Repositories\Categories\CategoryRepository;
use App\Services\TelegramWeb\Handlers\UpdateBook\UpdateBookInterface;
use App\Services\TelegramWeb\Handlers\UpdateBook\UpdateBookTelegramDTO;
use App\Services\TelegramWeb\Handlers\UpdateBook\UpdateBookTelegramStorage;
use Closure;

class CheckPagesHandler implements UpdateBookInterface
{
    private const NEXT_MESSAGE = 'Enter new existing category id:';

    public function __construct(
        protected UpdateBookTelegramStorage $storage,
        protected CategoryRepository $categoryRepository,
    ) {
    }

    /**
     * @param UpdateBookTelegramDTO $DTO
     * @param Closure $next
     * @return UpdateBookTelegramDTO
     */
    public function handle(UpdateBookTelegramDTO $DTO, Closure $next): UpdateBookTelegramDTO
    {
        $isPagesNotExists = $this->storage->isPagesNotExists($DTO->getSenderId());

        if ($isPagesNotExists === true) {
            $this->storage->setPages(
                $DTO->getSenderId(),
                $DTO->getArgument(),
            );

            $DTO->setMessage(self::NEXT_MESSAGE);
            return $DTO;
        }

        $DTO->setPages(
            $this->storage->getPages(
                $DTO->getSenderId(),
            )
        );

        return $next($DTO);
    }
}
