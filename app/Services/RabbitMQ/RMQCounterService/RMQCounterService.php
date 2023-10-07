<?php

namespace App\Services\RabbitMQ\RMQCounterService;

use App\Services\Supervisor\ProcessDTO;
use App\Services\Supervisor\SupervisorService;
use PhpAmqpLib\Message\AMQPMessage;

class RMQCounterService
{
    public const CONSUMER_COUNT = 2;

    public function __construct(
        protected RMQCounterDTO $DTO,
        protected SupervisorService $supervisorService,
    ) {
    }

    public function getCountsRabbit(AMQPMessage $message): void
    {
        $countMessage = $this->countMessages($message);
        $countConsumer = $message->getChannel()
            ->queue_declare(
                $this->DTO->getQueueName(),
                true
            )[2];

        if (
            $this->checkMessageCount($countMessage) === true &&
            $this->checkConsumerCount($countConsumer) === true
        ) {
            $this->addConsumer();
        }

        if (
            $this->checkMessageCount($countMessage) === false &&
            $this->checkConsumerCount($countConsumer) === false
        ) {
            $this->delConsumers();
        }
    }

    private function countMessages(AMQPMessage $message): int
    {
        if ($message->getChannel()->basic_get() !== null) {
            return $message->getChannel()->basic_get()->getMessageCount();
        }

        return 0;
    }

    private function checkMessageCount(int $countMessage): bool
    {
        if ($countMessage > $this->DTO->getMaxMessage()) {
            return true;
        }

        return false;
    }

    private function checkConsumerCount(int $countConsumer): bool
    {
        if ($countConsumer < self::CONSUMER_COUNT) {
            return true;
        }
        return false;
    }


    private function addConsumer(): void
    {
        $this->supervisorService->addProcesses(
            new ProcessDTO(
                $this->DTO->getSupervisorCommandName(),
                "php /var/www/html/artisan " . $this->DTO->getConsoleCommand(),
                $this->DTO->getMaxConsumer(),
            )
        );
        exec('supervisorctl reread');
        exec('supervisorctl update');
    }

    private function delConsumers(): void
    {
        $this->supervisorService->delete(
            $this->DTO->getSupervisorCommandName()
        );
        exec('supervisorctl reread');
        exec('supervisorctl update');
    }
}
