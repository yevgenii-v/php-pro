<?php
class Boat extends Transport
{
    /**
     * @param string $name
     * @param int $speed
     * @param int $passengers
     */
    public function __construct
    (
        protected string $name,
        protected int $speed,
        protected int $passengers,

    )
    {
        parent::__construct($name, $speed);
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