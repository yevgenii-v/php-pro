<?php

namespace App\Services\Messenger;

interface MessengerInterface
{
    /**
     * @param string $message
     * @return bool
     */
    public function send(string $message): bool;
}
