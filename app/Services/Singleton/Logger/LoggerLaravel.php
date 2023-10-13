<?php

namespace App\Services\Singleton\Logger;

use Carbon\Carbon;

/**
 * WARNING: This class registered as Singleton in AppServiceProvider.
 */
class LoggerLaravel
{
    protected array $logs = [];

    public function logMessage($message): void
    {
        $this->logs[] = [
            'time' => Carbon::now(),
            'message' => $message
        ];
    }

    public function getLog(): false|string
    {
        return json_encode($this->logs);
    }
}
