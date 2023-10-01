<?php

namespace App\Console\Commands\Supervisor;

use App\Services\Supervisor\ProcessDTO;
use App\Services\Supervisor\SupervisorService;
use Illuminate\Console\Command;

class UpdateProcess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'supervisor:update {name} {artisan_command} {number}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update supervisor process';

    /**
     * Execute the console command.
     */
    public function handle(SupervisorService $supervisorService): void
    {
        $process = new ProcessDTO(
            $this->argument('name'),
            'php /var/www/html/artisan ' . $this->argument('artisan_command'),
            $this->argument('number')
        );

        $isSectionExists = $supervisorService->hasSection($process->getName());
        if ($isSectionExists === false) {
            $this->error('This section do not exists.');
            return;
        }

        $supervisorService->updateProcess($process);

        exec('supervisorctl reread');
        exec('supervisorctl update');
        $this->info('Process was updated successfully.');
    }
}
