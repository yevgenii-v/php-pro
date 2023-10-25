<?php

namespace App\Console\Commands;

use App\Services\SwaggerService\SwaggerService;
use Illuminate\Console\Command;
use OpenApi\Generator;

class SwaggerGenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swagger:generate';

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
        $openApi = Generator::scan([SwaggerService::SCAN_PATH]);

        file_put_contents(
            public_path() . SwaggerService::FILENAME,
            $openApi->toJson()
        );
    }
}
