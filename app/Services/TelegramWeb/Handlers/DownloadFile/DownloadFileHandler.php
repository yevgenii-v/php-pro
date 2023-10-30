<?php

namespace App\Services\TelegramWeb\Handlers\DownloadFile;

use App\Services\TelegramWeb\CommandsInterface;

class DownloadFileHandler implements CommandsInterface
{
    public function handle(string $arguments, int $senderId): string
    {
        return 'download by link: ' . env('APP_URL') . '/api/v1/download/test.log';
    }
}
