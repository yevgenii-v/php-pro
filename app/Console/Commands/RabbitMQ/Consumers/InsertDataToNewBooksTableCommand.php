<?php

namespace App\Console\Commands\RabbitMQ\Consumers;

use App\Services\RabbitMQ\Books\BookRemoveConsumerService;
use Illuminate\Console\Command;

class InsertDataToNewBooksTableCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rmq:insert-new-books';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(BookRemoveConsumerService $service): void
    {
        $service->handle();
    }
}
