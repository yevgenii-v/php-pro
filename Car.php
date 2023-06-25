<?php

class Car extends Transport
{
    public function __construct
    (
        protected string $name,
        protected int $speed,
        protected int $numDoors
    )
    {
        parent::__construct($name, $speed);
    }

    /**
     * @return string
     */
    public function startEngine(): string
    {
        return 'Engine was started...';
    }


    /**
     * @return int
     */
    public function getNumDoors(): int
    {
        return $this->numDoors;
    }


    /**
     * @param int $value
     * @return Car
     */
    public function setNumDoors(int $value): static
    {
        $this->numDoors = $value;
        return $this;
    }


    /**
     * @return array
     */
    public function getInfo(): array
    {
        $data = parent::getInfo();
        $data['numDoors'] = $this->getNumDoors();

        return $data;
    }
}