<?php

class Transport
{
    protected string $name;
    protected int $speed;

    /**
     * @param string $name
     * @param int $speed
     */
    public function __construct
    (
        string $name = 'Transport',
        int $speed = 0,
    )
    {
        $this->name = $name;
        $this->speed = $speed;
    }

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
    public function getSpeed(): int
    {
        return $this->speed;
    }


    /**
     * @param string $name
     * @return Transport
     */
    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @param int $speed
     * @return Transport
     */
    public function setSpeed(int $speed): static
    {
        $this->speed = $speed;
        return $this;
    }


    /**
     * @return array
     */
    public function getInfo(): array
    {
        return [
            'name' => $this->getName(),
            'speed' => $this->getSpeed(),
        ];
    }

    /**
     * @param array $data
     * @return array
     */
    public function getAllObjects(array $data): array
    {
        $objects = [];

        foreach ($data as $object)
        {
            $objects[] = $object->getInfo();
        }

        return $objects;
    }
}