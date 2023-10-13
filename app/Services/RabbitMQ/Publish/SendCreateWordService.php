<?php

namespace App\Services\RabbitMQ\Publish;

use Bschmitt\Amqp\Facades\Amqp;
use Faker\Factory as Faker;

class SendCreateWordService
{
    public const QUEUE_NAME = 'word';
    private const EXEC_TIME = 300;

    public function handle(): void
    {
        $faker = Faker::create();
        $startTime = time();

        while ($this->checkTime($startTime) === true) {
            Amqp::publish(self::QUEUE_NAME, $faker->word(), [
                'queue' => self::QUEUE_NAME
            ]);
        }
    }

    private function checkTime(int $startTime): bool
    {
        $secondWork = time() - $startTime;

        return $secondWork < self::EXEC_TIME;
    }
}
