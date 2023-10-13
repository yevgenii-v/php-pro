<?php

namespace App\Services\Singleton\Logger;

use Carbon\Carbon;

/**
 * WARNING: This class registered as Singleton here.
 */
class LoggerVanilla
{
    private static ?LoggerVanilla $instance = null;
    private array $logs;

    /**
     * @return LoggerVanilla|null
     */
    public static function getInstance(): ?LoggerVanilla
    {
        return static::$instance ?? (static::$instance = new static());
    }

    private function __construct()
    {
    }

    /**
     * @param $message
     * @return void
     */
    public function logMessage($message): void
    {
        $this->logs[] = [
            'time' => Carbon::now(),
            'message' => $message
        ];
    }

    /**
     * @return false|string
     */
    public function getLog(): false|string
    {
        return json_encode($this->logs);
    }
}
