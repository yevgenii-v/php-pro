<?php

namespace App\Console\Commands\RabbitMQ\Publish;

use App\Services\RabbitMQ\Publish\SendCreateWordService;
use Illuminate\Console\Command;

class WordPublish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:word-publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(SendCreateWordService $sendCreateWordService): void
    {
        $sendCreateWordService->handle();
    }
}
