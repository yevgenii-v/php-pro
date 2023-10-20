<?php

namespace App\Console;

use App\Console\Commands\Proxy\RefreshProxyList;
use App\Console\Commands\UpdateBookStatistics;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
//         $schedule->command(RefreshProxyList::class)->everyThirtyMinutes();
         $schedule->command(UpdateBookStatistics::class)->everyOddHour();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
