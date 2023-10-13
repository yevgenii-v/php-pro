<?php

namespace App\Console\Commands;

use App\Services\Singleton\Example\SingletonExample;
use App\Services\Singleton\Logger\LoggerLaravel;
use App\Services\Singleton\Logger\LoggerVanilla;
use Illuminate\Console\Command;

class SingletonCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:singleton';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $loggerVanilla = LoggerVanilla::getInstance();
        $loggerVanilla->logMessage('warning1');
        $loggerVanilla->logMessage('warning2');
        var_dump($loggerVanilla->getLog());

        $logger = app(LoggerLaravel::class);
        $logger->logMessage('error1');
        $logger->logMessage('error2');
        var_dump($logger->getLog());
    }
}
