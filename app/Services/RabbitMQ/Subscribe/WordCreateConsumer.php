<?php

namespace App\Services\RabbitMQ\Subscribe;

use App\Services\Proxy\ProxiesStorage;
use App\Services\Proxy\WebShareService;
use App\Services\RabbitMQ\Publish\SendCreateWordService;
use App\Services\RabbitMQ\RMQCounterService\RMQCounterDTO;
use App\Services\RabbitMQ\RMQCounterService\RMQCounterService;
use App\Services\Supervisor\SupervisorService;
use App\Services\WordResult\WordResultDTO;
use App\Services\WordResult\WordResultService;
use Bschmitt\Amqp\Facades\Amqp;
use GuzzleHttp\Exception\GuzzleException;
use PhpAmqpLib\Message\AMQPMessage;

class WordCreateConsumer
{
    protected const API_URL = 'https://api.duckduckgo.com/?q=';
    protected const FORMAT = '&format=json';
    protected const CONSOLE_COMMAND = "app:word-subscribe";
    protected const SUPERVISOR_COMMAND_NAME = "consumer_add";
    protected const MAX_MESSAGE = 1000;
    protected const MAX_CONSUMER = 5;

    public function __construct(
        protected WordResultService $wordResultService,
        protected WebShareService $webShareService,
        protected SupervisorService $supervisorService,
    ) {
    }

    /**
     * @return void
     * @throws GuzzleException
     */
    public function handle(): void
    {
        $this->webShareService->checkProxyList();

        Amqp::consume(SendCreateWordService::QUEUE_NAME, function (AMQPMessage $message) {

            $DTO = new WordResultDTO(
                $message->getBody(),
                self::API_URL,
                self::FORMAT,
                self::MAX_MESSAGE,
                SendCreateWordService::QUEUE_NAME,
                self::SUPERVISOR_COMMAND_NAME,
                self::CONSOLE_COMMAND,
                self::MAX_CONSUMER
            );

            $updatedDTO = $this->wordResultService->handle($DTO);

            $message->ack();

            $RMQCounterService = new RMQCounterService(
                new RMQCounterDTO(
                    $updatedDTO->getQueueName(),
                    $updatedDTO->getMaxMessage(),
                    $updatedDTO->getSupervisorCommandName(),
                    $updatedDTO->getConsoleCommand(),
                    $updatedDTO->getMaxConsumer(),
                ),
                $this->supervisorService,
            );

            $RMQCounterService->getCountsRabbit($message);
        });
    }
}
