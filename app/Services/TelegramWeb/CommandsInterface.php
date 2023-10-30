<?php

namespace App\Services\TelegramWeb;

interface CommandsInterface
{
    /**
     * @param string $arguments
     * @param int $senderId
     * @return string
     */
    public function handle(string $arguments, int $senderId): string;
}
