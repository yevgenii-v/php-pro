<?php

namespace App\Services\WordResult;

use App\Repositories\WordResultRepository\WordResultStoreDTO;
use App\Services\Proxy\ProxyDTO;
use PhpAmqpLib\Message\AMQPMessage;

class WordResultDTO
{
    protected ProxyDTO $proxyDTO;
    protected WordResultStoreDTO $wordResultStoreDTO;

    public function __construct(
        protected string $body,
        protected string $apiUrl,
        protected string $apiFormat,
        protected int $maxMessage,
        protected string $queueName,
        protected string $supervisorCommandName,
        protected string $consoleCommand,
        protected int $maxConsumer
    ) {
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return ProxyDTO
     */
    public function getProxyDTO(): ProxyDTO
    {
        return $this->proxyDTO;
    }

    /**
     * @param ProxyDTO $proxyDTO
     */
    public function setProxyDTO(ProxyDTO $proxyDTO): void
    {
        $this->proxyDTO = $proxyDTO;
    }

    /**
     * @return string
     */
    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    /**
     * @return string
     */
    public function getApiFormat(): string
    {
        return $this->apiFormat;
    }

    /**
     * @return WordResultStoreDTO
     */
    public function getWordResultStoreDTO(): WordResultStoreDTO
    {
        return $this->wordResultStoreDTO;
    }

    /**
     * @param WordResultStoreDTO $wordResultStoreDTO
     */
    public function setWordResultStoreDTO(WordResultStoreDTO $wordResultStoreDTO): void
    {
        $this->wordResultStoreDTO = $wordResultStoreDTO;
    }

    /**
     * @return string
     */
    public function getQueueName(): string
    {
        return $this->queueName;
    }

    /**
     * @return int
     */
    public function getMaxMessage(): int
    {
        return $this->maxMessage;
    }

    /**
     * @return string
     */
    public function getSupervisorCommandName(): string
    {
        return $this->supervisorCommandName;
    }

    /**
     * @return string
     */
    public function getConsoleCommand(): string
    {
        return $this->consoleCommand;
    }

    /**
     * @return int
     */
    public function getMaxConsumer(): int
    {
        return $this->maxConsumer;
    }

}
