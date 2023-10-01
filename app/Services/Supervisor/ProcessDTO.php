<?php

namespace App\Services\Supervisor;

class ProcessDTO
{
    public function __construct(
        protected string $name,
        protected string $command,
        protected int $number,
    ) {
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
    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }
}
