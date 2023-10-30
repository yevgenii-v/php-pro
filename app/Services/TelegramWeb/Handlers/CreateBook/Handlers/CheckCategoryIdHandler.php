<?php

namespace App\Services\TelegramWeb\Handlers\CreateBook\Handlers;

use App\Services\TelegramWeb\Handlers\CreateBook\CreateBookInterface;
use App\Services\TelegramWeb\Handlers\CreateBook\CreateBookTelegramDTO;
use Closure;

class CheckCategoryIdHandler implements CreateBookInterface
{
    /**
     * @param CreateBookTelegramDTO $DTO
     * @param Closure $next
     * @return CreateBookTelegramDTO
     */
    public function handle(CreateBookTelegramDTO $DTO, Closure $next): CreateBookTelegramDTO
    {
        $DTO->setCategoryId(
            $DTO->getArgument()
        );

        return $next($DTO);
    }
}
