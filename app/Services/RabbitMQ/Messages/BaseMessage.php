<?php

namespace App\Services\RabbitMQ\Messages;

use Carbon\Carbon;
use JsonSerializable;
use ReflectionClass;
use UnitEnum;

class BaseMessage implements JsonSerializable
{
    public function __construct(object $data)
    {
        $reflect = new ReflectionClass($this);;

        foreach ($reflect->getProperties() as $property) {
            $propertyName = $property->getName();
            $type = $property->getType()->getName();
            $value = $data->$propertyName;

            if (enum_exists($type) === true) {
                /** @var UnitEnum $type */
                $value = $type::from($value);
            }

            if ($type === Carbon::class) {
                $value = Carbon::parse($value);
            }

            $this->$propertyName = $value;
        }
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
