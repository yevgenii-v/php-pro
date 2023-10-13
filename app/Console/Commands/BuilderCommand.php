<?php

namespace App\Console\Commands;

use App\Enums\Lang;
use App\Services\RabbitMQ\Messages\BookCreateMessageDTO;
use Carbon\Carbon;
use Illuminate\Console\Command;

class BuilderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:builder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $message = new BookCreateMessageDTO(
            (object)[
                'name'          => 'cat name',
                'year'          => 1992,
                'lang'          => Lang::EN->value,
                'pages'         => 777,
                'categoryId'    => 4,
                'createdAt'     => Carbon::now(),
            ]
        );

        $encoded = json_encode($message);
        $this->info($encoded);

        //subscribe

        $newMessage = new BookCreateMessageDTO((object)json_decode($encoded, true));
        var_dump($newMessage);
    }
}
