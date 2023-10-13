<?php

namespace App\Services\RabbitMQ\Messages;

use Carbon\Carbon;

class AuthorCreateMessageDTO extends BaseMessage
{
    protected string $name;
    protected Carbon $createdAt;
    protected Carbon $updatedAt;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

    /**
     * @return Carbon
     */
    public function getUpdatedAt(): Carbon
    {
        return $this->updatedAt;
    }
}
