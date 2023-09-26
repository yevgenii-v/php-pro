<?php

namespace App\Console\Commands\Redis;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class UseIncrForRedisValue extends Command
{
    private const INCR = 1;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:incr {key}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Increase integer by increment';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $redis = Redis::get($this->argument('key'));

        if (ctype_digit($redis) === true) {
            Redis::incr($this->argument('key'), self::INCR);
            $this->info('Value was increased successfully');
            return;
        }

        $this->info('Current value is not an integer.');
    }
}
