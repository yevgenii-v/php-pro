<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Services\TelegramWeb\IncomeDTO;
use App\Services\TelegramWeb\TelegramIncomeService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{
    public function __construct(
        protected TelegramIncomeService $service
    ) {
    }

    /**
     * @throws GuzzleException
     */
    public function index(Request $request): string
    {
        Log::info(json_encode($request->all()));
        $data = new IncomeDTO($request->all());
        $this->service->handle($data);

        return 'TestController->index';
    }
}
