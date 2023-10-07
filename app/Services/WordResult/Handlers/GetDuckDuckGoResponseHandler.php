<?php

namespace App\Services\WordResult\Handlers;

use App\Repositories\WordResultRepository\WordResultStoreDTO;
use App\Services\WordResult\WordResultDTO;
use App\Services\WordResult\WordResultInterface;
use Closure;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;

class GetDuckDuckGoResponseHandler implements WordResultInterface
{
    public function __construct(
        protected GuzzleClient $guzzleClient,
    ) {
    }

    /**
     * @param WordResultDTO $DTO
     * @param Closure $next
     * @return WordResultDTO
     * @throws GuzzleException
     */
    public function handle(WordResultDTO $DTO, Closure $next): WordResultDTO
    {
        $response = $this->guzzleClient->get(
            $DTO->getApiUrl() . $DTO->getBody() . $DTO->getApiFormat(),
            [
                "proxy" => $DTO->getProxyDTO()->getData(),
            ]);

        $response = json_decode($response->getBody()->getContents(), true);

        $DTO->setWordResultStoreDTO(
            new WordResultStoreDTO(
                $DTO->getBody(),
                $response['AbstractSource']
            )
        );

        return $next($DTO);
    }
}
