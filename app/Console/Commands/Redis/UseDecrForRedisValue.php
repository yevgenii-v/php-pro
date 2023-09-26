<?php

namespace App\Console\Commands\Redis;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class UseDecrForRedisValue extends Command
{
    private const DECR = 1;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:decr {key}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Decrease integer by decrement';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $redis = Redis::get($this->argument('key'));

        if (ctype_digit($redis) === true) {
            Redis::decr($this->argument('key'), self::DECR);
            $this->info('Value was decreased successfully');
            return;
        }

        $this->info('Current value is not an integer.');
    }
}
