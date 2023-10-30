<?php

namespace App\Services\RabbitMQ\Books;

use App\Console\Commands\RabbitMQ\Publish\GetDataFromOldBooksTableCommand;
use App\Enums\Lang;
use App\Repositories\Books\BookRepository;
use App\Repositories\Books\NewBookStoreDTO;
use Bschmitt\Amqp\Facades\Amqp;
use Carbon\Carbon;
use PhpAmqpLib\Message\AMQPMessage;

class BookRemoveConsumerService
{
    public function __construct(
        protected BookRepository $bookRepository,
    ) {
    }

    public function handle(): void
    {
        Amqp::consume(GetDataFromOldBooksTableCommand::QUEUE_NAME, function (AMQPMessage $message) {
            $data = json_decode($message->getBody(), true);

            $bookDTO = new NewBookStoreDTO(
                $data['id'],
                $data['name'],
                $data['year'],
                Lang::from($data['lang']),
                $data['pages'],
                $data['category']['id'],
                new Carbon($data['createdAt']),
                new Carbon($data['updatedAt']),
            );

            $this->bookRepository->storeIntoNewBooks($bookDTO);

            $message->ack();
        });
    }
}
