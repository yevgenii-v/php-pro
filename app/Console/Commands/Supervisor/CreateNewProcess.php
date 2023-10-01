<?php

namespace App\Console\Commands\Supervisor;

use App\Services\Supervisor\ProcessDTO;
use App\Services\Supervisor\SupervisorService;
use Illuminate\Console\Command;

class CreateNewProcess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'supervisor:create {name} {artisan_command} {number}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new process in supervisor';

    /**
     * Execute the console command.
     */
    public function handle(SupervisorService $supervisorService): void
    {
        $processDTO = new ProcessDTO(
            $this->argument('name'),
            'php /var/www/html/artisan ' . $this->argument('artisan_command'),
            $this->argument('number'),
        );

        if ($supervisorService->hasSection($processDTO->getName()) === false) {
            $supervisorService->addProcessConfig($processDTO);
            $this->info('Created new process success');
            exec('supervisorctl reread');
            exec('supervisorctl update');
        }
    }
}
