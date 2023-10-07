<?php

namespace App\Console\Commands\RabbitMQ\Consumers;

use App\Services\RabbitMQ\Subscribe\WordCreateConsumer;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

class WordSubscribe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:word-subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     * @throws GuzzleException
     */
    public function handle(WordCreateConsumer $consumer): void
    {
        $consumer->handle();
    }
}
