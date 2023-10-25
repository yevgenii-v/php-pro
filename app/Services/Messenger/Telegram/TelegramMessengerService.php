<?php

namespace App\Services\Messenger\Telegram;

use App\Services\Messenger\MessengerInterface;
use Exception;
use GuzzleHttp\Client as GuzzleClient;
use TelegramBot\Api\BotApi as TelegramApi;

class TelegramMessengerService implements MessengerInterface
{
    public function __construct(
        protected GuzzleClient $client
    ) {
    }

    /**
     * @param string $message
     * @return bool
     * @throws Exception
     */
    public function send(string $message): bool
    {
        $telegram = new TelegramApi(config('messenger.telegram.token'));
        $telegram->sendMessage(
            config('messenger.telegram.chat_id'),
            $message,
        );

        return true;
    }
}
