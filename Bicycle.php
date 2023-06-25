<?php

class Bicycle extends Transport
{
    public function __construct
    (
        protected string $name,
        protected int $speed,
        protected int $numGears
    )
    {
        parent::__construct($name, $speed);
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