<?php

namespace App\Services\RabbitMQ\RMQCounterService;

use App\Services\Supervisor\SupervisorService;
use PhpAmqpLib\Message\AMQPMessage;

class RMQCounterDTO
{
    public function __construct(
        protected string $queueName,
        protected int $maxMessage,
        protected string $supervisorCommandName,
        protected string $consoleCommand,
        protected int $maxConsumer,
    ) {
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
