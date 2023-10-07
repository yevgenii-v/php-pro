<?php

namespace App\Services\RabbitMQ\Subscribe;

use App\Enums\Lang;
use App\Repositories\Books\BookRepository;
use App\Repositories\Books\BookStoreDTO;
use App\Services\RabbitMQ\Messages\BookCreateMessageDTO;
use App\Services\RabbitMQ\Publish\SendBookCreateService;
use Bschmitt\Amqp\Facades\Amqp;
use PhpAmqpLib\Message\AMQPMessage;

class BookCreateConsumer
{
    public function __construct(
        protected BookRepository $bookRepository
    ) {
    }

    public function handle(): void
    {
        Amqp::consume(SendBookCreateService::QUEUE_NAME, function (AMQPMessage $message) {

            $book = json_decode($message->getBody(), true);
            $convertBook = new BookCreateMessageDTO((object)$book);

            $messageDTO = new BookStoreDTO(
                $convertBook->getName(),
                $convertBook->getYear(),
                $convertBook->getLang(),
                $convertBook->getPages(),
                $convertBook->getCategoryId(),
            );

            $this->bookRepository->store($messageDTO);
            $message->ack();
        });
    }
}
