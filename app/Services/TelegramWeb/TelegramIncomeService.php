<?php

namespace App\Services\TelegramWeb;

use App\Enums\TelegramCommands;
use App\Services\Messenger\Telegram\TelegramMessengerService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Redis;

class TelegramIncomeService
{
    public const COMMAND_SLASH = '/';
    public function __construct(
        protected TelegramMessengerService $telegramMessengerService,
        protected CommandsFactory $commandsFactory,
    ) {
    }

    /**
     * @throws GuzzleException
     */
    public function handle(IncomeDTO $incomeDTO): void
    {
        $command = TelegramCommands::tryFrom($incomeDTO->getText());

        if (is_null($command) === true) {
            $command = TelegramCommands::tryFrom(
                Redis::get('lastCommand' . $incomeDTO->getSenderId())
            );
        }

        if (is_null($command) === true) {
            $command = TelegramCommands::from('/info');
        }

        Redis::set('lastCommand' . $incomeDTO->getSenderId(), $command->value);

        $service = $this->commandsFactory->handle($command);
        $this->telegramMessengerService->send(
            $service->handle($incomeDTO->getText(), $incomeDTO->getSenderId()),
            $incomeDTO->getSenderId()
        );
    }
}
