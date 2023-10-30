<?php

namespace App\Services\TelegramWeb\Handlers\UpdateBook\Handlers;

use App\Repositories\Categories\CategoryRepository;
use App\Services\TelegramWeb\Handlers\UpdateBook\UpdateBookInterface;
use App\Services\TelegramWeb\Handlers\UpdateBook\UpdateBookTelegramDTO;
use Closure;

class CheckCategoryIdHandler implements UpdateBookInterface
{
    public function __construct(
        protected CategoryRepository $categoryRepository,
    ) {
    }
    /**
     * @inheritDoc
     */
    public function handle(UpdateBookTelegramDTO $DTO, Closure $next): UpdateBookTelegramDTO
    {
        $isExistsInDB = $this->categoryRepository->isExistsById($DTO->getArgument());

        if ($isExistsInDB === false) {
            $DTO->setMessage('Invalid category id');
            return $DTO;
        }

        $DTO->setCategoryId($DTO->getArgument());
        return $next($DTO);
    }
}
