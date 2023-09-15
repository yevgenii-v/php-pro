<?php

namespace App\Console\Commands\Redis;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class CreateExpireValue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:create {key} {value} {expire_time}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a value that will expire';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Redis::set(
            $this->argument('key'),
            $this->argument('value'),
            'EX',
            $this->argument('expire_time'),
        );

        $this->info('New data in Redis has been created.');
    }
}
