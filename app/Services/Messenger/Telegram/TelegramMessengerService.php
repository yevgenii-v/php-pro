<?php

namespace App\Services\Messenger\Telegram;

use App\Services\Messenger\MessengerInterface;
use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;

class TelegramMessengerService implements MessengerInterface
{
    public function __construct(
        protected GuzzleClient $guzzleClient
    ) {
    }

    /**
     * @param string $message
     * @param int|null $chatId
     * @return bool
     * @throws GuzzleException
     * @throws Exception
     */
    public function send(string $message, int $chatId = null): bool
    {
        if (is_null($chatId) === true) {
            $chatId = config('messenger.telegram.chat_id');
        }

        $this->guzzleClient->post(config('messenger.telegram.url'), [
            'json' => [
                'chat_id'   => $chatId,
                'text'      => $message
            ]
        ]);

        return true;
    }
}
