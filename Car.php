<?php

class Car extends Transport
{
    protected int $numDoors;

    public function __construct(string $name, int $speed, int $numDoors)
    {
        parent::__construct($name, $speed);
        $this->numDoors = $numDoors;
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