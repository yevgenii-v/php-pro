<?php

namespace App\Services\RabbitMQ\Subscribe;

use App\Repositories\Categories\CategoryRepository;
use App\Services\RabbitMQ\Messages\CategoryCreateMessageDTO;
use App\Services\RabbitMQ\Publish\SendCategoryCreateService;
use Bschmitt\Amqp\Facades\Amqp;
use PhpAmqpLib\Message\AMQPMessage;

class CategoryCreateConsumer
{
    public function __construct(
        protected CategoryRepository $categoryRepository,
    ) {
    }

    public function handle(): void
    {
        Amqp::consume(SendCategoryCreateService::QUEUE_NAME, function (AMQPMessage $message) {

            $messageDTO = new CategoryCreateMessageDTO(
                ...json_decode(
                    $message->getBody(),
                    true
                )
            );

            $this->categoryRepository->insert($messageDTO);

            $message->ack();
        });
    }
}
