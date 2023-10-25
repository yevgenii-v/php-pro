<?php

namespace App\Services\Messenger;

use App\Enums\Messenger;
use App\Services\Messenger\Slack\SlackMessengerService;
use App\Services\Messenger\Telegram\TelegramMessengerService;

class MessengerFactory
{
    /**
     * @param Messenger $messenger
     * @return MessengerInterface
     */
    public function handle(Messenger $messenger): MessengerInterface
    {
        return match ($messenger) {
            Messenger::SLACK    => app(SlackMessengerService::class),
            Messenger::TELEGRAM => app(TelegramMessengerService::class),
        };
    }
}
