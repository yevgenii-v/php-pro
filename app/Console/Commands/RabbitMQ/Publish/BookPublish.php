<?php

namespace App\Console\Commands\RabbitMQ\Publish;

use App\Services\RabbitMQ\Publish\SendBookCreateService;
use Illuminate\Console\Command;

class BookPublish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:book-publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(SendBookCreateService $service): void
    {
        $service->handle();
    }
}
