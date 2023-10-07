<?php

namespace App\Services\RabbitMQ\Publish;

use App\Services\RabbitMQ\Messages\CategoryCreateMessageDTO;
use Bschmitt\Amqp\Facades\Amqp;

class SendCategoryCreateService
{
    public const QUEUE_NAME = 'create_category';

    public function handle(): void
    {
        $message = new CategoryCreateMessageDTO(
            'new_category' . rand(1, 999),
            time(),
            time(),
        );

        Amqp::publish(self::QUEUE_NAME, json_encode($message), [
            'queue' => self::QUEUE_NAME
        ]);
    }
}
