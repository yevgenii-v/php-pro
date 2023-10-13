<?php

namespace App\Services\RabbitMQ\Publish;

use App\Services\RabbitMQ\Messages\BookCreateMessageDTO;
use Bschmitt\Amqp\Facades\Amqp;
use Carbon\Carbon;

class SendBookCreateService
{
    public const QUEUE_NAME = 'create_book';
    public array $lang = ['en', 'ua', 'de', 'pl'];
    private const EXEC_TIME = 300;

    public function handle(): void
    {
        $startTime = time();

        while ($this->checkTime($startTime) === true) {
            $data = (object)[
                'name'          => 'bookName' . rand(1, 10000000) . uniqid(),
                'year'          => rand(1970, 2023),
                'lang'          => $this->getRandLang($this->lang),
                'pages'         => rand(15, 1000),
                'categoryId'    => rand(1, 200),
                'createdAt'     => Carbon::now(),
            ];

            $DTO = new BookCreateMessageDTO($data);

            Amqp::publish(self::QUEUE_NAME, json_encode($DTO), [
                'queue' => self::QUEUE_NAME
            ]);
        }
    }

    private function checkTime(int $time): bool
    {
        $secondWork = time() - $time;
        if ($secondWork < self::EXEC_TIME) {
            return true;
        }

        return false;
    }

    private function getRandLang(array $lang): string
    {
        return array_rand(array_flip($lang));
    }
}
