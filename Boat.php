<?php
class Boat extends Transport
{
    protected int $passengers;

    /**
     * @param string $name
     * @param int $speed
     * @param int $passengers
     */
    public function __construct(string $name = 'Transport', int $speed = 0, int $passengers = 0)
    {
        parent::__construct($name, $speed);
        $this->passengers = $passengers;
    }

    /**
     * @return string
     */
    public function sail(): string
    {
        return 'Boat is sailing with ' . $this->getPassengers() . ' passenger(s).';
    }

    /**
     * @return int
     */
    public function getPassengers(): int
    {
        return $this->passengers;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setPassengers($value): Boat
    {
        $this->passengers = $value;
        return $this;
    }

    /**
     * @return array
     */
    public function getInfo(): array
    {
        $data = parent::getInfo();
        $data['passengers'] = $this->passengers;
        return $data;
    }
}