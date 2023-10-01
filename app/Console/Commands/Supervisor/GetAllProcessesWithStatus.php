<?php

namespace App\Console\Commands\Supervisor;

use App\Services\Supervisor\SupervisorService;
use Illuminate\Console\Command;

class GetAllProcessesWithStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'supervisor:get-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show all processes in supervisor with status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $processes = [];
        exec('supervisorctl status', $processes);

        foreach ($processes as $process) {
            echo $process . PHP_EOL;
        }
    }
}
