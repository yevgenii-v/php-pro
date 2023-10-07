<?php

namespace App\Console\Commands\RabbitMQ\Consumers;

use App\Services\RabbitMQ\Subscribe\BookCreateConsumer;
use Illuminate\Console\Command;

class BookSubscribe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:book-subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(BookCreateConsumer $consumer): void
    {
        $consumer->handle();
    }
}
