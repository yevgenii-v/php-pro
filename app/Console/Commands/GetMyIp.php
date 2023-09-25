<?php

namespace App\Console\Commands;

use App\Services\GetMyIp\GetMyIpService;
use Illuminate\Console\Command;

class GetMyIp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-my-ip';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(GetMyIpService $service): void
    {
        while (true) {
            $startTime = microtime(true);
            $this->info($service->handle());
            $time = microtime(true) - $startTime;
            $this->info($time);
            sleep(1);
        }
    }
}
