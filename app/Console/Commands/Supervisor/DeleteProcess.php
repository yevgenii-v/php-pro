<?php

namespace App\Console\Commands\Supervisor;

use App\Services\Supervisor\SupervisorService;
use Illuminate\Console\Command;

class DeleteProcess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'supervisor:delete {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '\Delete process from supervision';

    /**
     * Execute the console command.
     */
    public function handle(SupervisorService $supervisorService): void
    {
        $supervisorService->delete($this->argument('name'));
        exec('supervisorctl reread');
        exec('supervisorctl update');

        $this->info('Process was successfully deleted.');
    }
}
