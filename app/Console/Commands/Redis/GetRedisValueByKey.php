<?php

namespace App\Console\Commands\Redis;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class GetRedisValueByKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:get {key}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get value from Redis by key';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $value = Redis::get($this->argument('key'));

        $this->info('Current value is ' . $value);
    }
}
