<?php

namespace App\Console\Commands\Redis;

use App\Console\Commands\Redis\DTO\RedisDataDTO;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class SubscribeRedisChannel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribe to a Redis channel';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Redis::subscribe(['test-channel'], function (string $message) {
            $data = json_decode($message, true);
            $DTO = new RedisDataDTO($data['id'], $data['name']);

            $this->info('id: ' . $DTO->getId());
            $this->info('name: ' . $DTO->getName());
        });
    }
}
