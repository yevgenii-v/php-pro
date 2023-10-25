<?php

namespace App\Console\Commands;

use App\Enums\Messenger;
use App\Services\Messenger\MessengerFactory;
use App\Services\Messenger\Slack\SlackMessengerService;
use App\Services\Messenger\Telegram\TelegramMessengerService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendMessagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'messengers:send {message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     * @throws Exception
     */
    public function handle(MessengerFactory $service): void
    {
        foreach (Messenger::cases() as $messenger) {
            Log::info($service->handle($messenger)->send('text from ' . $this->argument('message')));
        }
    }
}
