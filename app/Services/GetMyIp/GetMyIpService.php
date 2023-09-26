<?php

namespace App\Services\GetMyIp;

use App\Services\Proxy\ProxiesStorage;
use App\Services\Proxy\WebShareService;
use GuzzleHttp\Client;

class GetMyIpService
{
    private const MIN_EXECUTION_SECONDS = 1;
    public function __construct(
        protected Client $client,
        protected WebShareService $webShareService,
        protected ProxiesStorage $proxiesStorage,
    ) {
    }

    public function handle(): string
    {
        $countProxies = count($this->proxiesStorage->lrange());

        if ($countProxies < 5) {
            $this->proxiesStorage->del();
            $this->webShareService->refreshProxyList();
        }

        $proxyDTO = $this->proxiesStorage->lpop();

        $startTime = microtime(true);

        $response = $this->client->get(
            'https://api.myip.com/',
            [
                'proxy' => $proxyDTO->getData(),
            ]
        );
        $time = microtime(true) - $startTime;
        if ($time < self::MIN_EXECUTION_SECONDS) {
            $this->proxiesStorage->rpush($proxyDTO);
        }

        return $response->getBody()->getContents();
    }
}
