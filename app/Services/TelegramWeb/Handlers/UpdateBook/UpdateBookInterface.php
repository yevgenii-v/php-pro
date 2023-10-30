<?php

namespace App\Services\TelegramWeb\Handlers\UpdateBook;

use Closure;

interface UpdateBookInterface
{
    /**
     * @param UpdateBookTelegramDTO $DTO
     * @param Closure $next
     * @return UpdateBookTelegramDTO
     */
    public function handle(UpdateBookTelegramDTO $DTO, Closure $next): UpdateBookTelegramDTO;
}
