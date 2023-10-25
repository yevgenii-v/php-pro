<?php

namespace App\Services\Messenger\Slack;

use App\Services\Messenger\MessengerInterface;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;

class SlackMessengerService implements MessengerInterface
{
    public function __construct(
        protected GuzzleClient $client,
    ) {
    }

    /**
     * @param string $message
     * @return bool
     * @throws GuzzleException
     */
    public function send(string $message): bool
    {
        $this->client->post(config('messenger.slack.url'), [
            'json' => [
                'text' => $message
            ]
        ]);

        return true;
    }
}
