<?php

namespace App\Console\Commands\Redis;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class DeleteRedisValueByKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:delete {key}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Destroy value from Redis';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Redis::del($this->argument('key'));

        $this->info('It was successfully deleted');
    }
}
