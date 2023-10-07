<?php

namespace App\Console\Commands\RabbitMQ\Consumers;

use App\Services\RabbitMQ\Subscribe\CategoryCreateConsumer;
use Illuminate\Console\Command;

class RabbitSubscribe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:rabbit-subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(CategoryCreateConsumer $consumer): void
    {
        $consumer->handle();
    }
}
