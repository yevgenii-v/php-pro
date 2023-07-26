<?php

namespace App\Repositories\Authentication\Iterators;

use Carbon\Carbon;

class RegisteredUserIterator
{
    protected int $id;

    protected string $name;

    protected string $email;

    protected Carbon $createdAt;

    /**
     * @param object $data
     */
    public function __construct(object $data)
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->email = $data->email;
        $this->createdAt = new Carbon($data->created_at);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }
}
