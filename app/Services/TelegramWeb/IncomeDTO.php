<?php

namespace App\Services\TelegramWeb;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class IncomeDTO
{
    protected int $updatedId;
    protected int $senderId;
    protected string $text;
    protected Carbon $date;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        Log::info(json_encode($data));

        $this->updatedId    = $data['update_id'];
        $this->text         = $data['message']['text'];
        $this->senderId     = $data['message']['from']['id'];
        $this->date         = Carbon::createFromTimestamp($data['message']['date']);
    }

    /**
     * @return int
     */
    public function getUpdatedId(): int
    {
        return $this->updatedId;
    }

    /**
     * @return int
     */
    public function getSenderId(): int
    {
        return $this->senderId;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return Carbon
     */
    public function getDate(): Carbon
    {
        return $this->date;
    }
}
