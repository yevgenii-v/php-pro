<?php

namespace App\Services\Proxy;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Redis;

class WebShareService
{
    public function __construct(
        protected Client $client,
        protected ProxiesStorage $proxiesStorage,
    ) {
    }

    /**
     * @throws GuzzleException
     */
    public function getProxyList(): void
    {
        $response = $this->client->get(
            'https://proxy.webshare.io/api/v2/proxy/list',
            [
                'query' => [
                    'mode'      => 'direct',
                ],
                'headers' => [
                    'Authorization' => 'Token ' . config('proxy.key'),
                ]
            ]
        );

        $content = $response->getBody()->getContents();
        $proxies = [];

        foreach (json_decode($content)->results as $result) {
            $proxy = [
                'username'      => $result->username,
                'password'      => $result->password,
                'ip'            => $result->proxy_address,
                'port'          => $result->port,
            ];
            $this->proxiesStorage->lpush(new ProxyDTO(...$proxy));
            $proxies[] = $proxy;
        }

        print_r($proxies);
    }

    public function refreshProxyList(): void
    {
        $request = $this->client->post(
            'https://proxy.webshare.io/api/v2/proxy/list/refresh/',
            [
                'headers' => [
                    'Authorization' => 'Token ' . config('proxy.key')
                ],
            ]
        );

        $response = $request->getBody()->getContents();

        foreach (json_decode($response)->results as $result) {
            $proxy = [
                'username'      => $result->username,
                'password'      => $result->password,
                'ip'            => $result->proxy_address,
                'port'          => $result->port,
            ];

            $this->proxiesStorage->rpush(new ProxyDTO(...$proxy));
        }
    }

    /**
     * @throws GuzzleException
     */
    public function checkProxyList(): void
    {
        if ($this->proxiesStorage->llen() < 1) {
            $this->getProxyList();
        }
    }
}
