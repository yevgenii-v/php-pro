<?php

namespace App\Console\Commands\Redis;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class PublishRedisChannel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish to a Redis channel';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        while (true) {
            Redis::publish('test-channel', json_encode([
                'id' => 1,
                'name' => 'Jack West'
            ]));
            sleep(5);
        }
    }
}
