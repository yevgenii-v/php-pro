<?php

namespace App\Console\Commands\Proxy;

use App\Services\Proxy\WebShareService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

class Proxy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proxy:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     * @throws GuzzleException
     */
    public function handle(WebShareService $service): void
    {
        $service->getProxyList();
    }
}
