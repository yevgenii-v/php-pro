<?php

namespace App\Services\RabbitMQ\Messages;

use App\Enums\Lang;
use Carbon\Carbon;
use JsonSerializable;

class BookCreateMessageDTO extends BaseMessage
{
    protected string $name;
    protected int $year;
    protected Lang $lang;
    protected int $pages;
    protected int $categoryId;
    protected Carbon $createdAt;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @return Lang
     */
    public function getLang(): Lang
    {
        return $this->lang;
    }

    /**
     * @return int
     */
    public function getPages(): int
    {
        return $this->pages;
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }
}
