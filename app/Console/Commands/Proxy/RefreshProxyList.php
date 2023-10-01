<?php

namespace App\Console\Commands\Proxy;

use App\Services\Proxy\WebShareService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RefreshProxyList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proxy:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh proxy list (only with payed account)';

    /**
     * Execute the console command.
     */
    public function handle(WebShareService $webShareService)
    {
        $webShareService->refreshProxyList();
    }
}
