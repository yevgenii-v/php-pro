<?php

class Bicycle extends Transport
{
    protected int $numGears;
    public function __construct(string $name, int $speed, int $numGears)
    {
        parent::__construct($name, $speed);
        $this->numGears = $numGears;
    }

    /**
     * @return string
     */
    public function ringBell(): string
    {
        return 'Bell is chiming...';
    }


    /**
     * @return int
     */
    public function getNumGears(): int
    {
        return $this->numGears;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setNumGears($value): Bicycle
    {
        $this->numGears = $value;
        return $this;
    }

    /**
     * @return array
     */
    public function getInfo(): array
    {
        $data = parent::getInfo();
        $data['numGears'] = $this->getNumGears();

        return $data;
    }
}