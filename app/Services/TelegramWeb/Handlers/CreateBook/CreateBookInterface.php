<?php

namespace App\Services\TelegramWeb\Handlers\CreateBook;

use Closure;

interface CreateBookInterface
{
    /**
     * @param CreateBookTelegramDTO $DTO
     * @param Closure $next
     * @return CreateBookTelegramDTO
     */
    public function handle(CreateBookTelegramDTO $DTO, Closure $next): CreateBookTelegramDTO;
}
