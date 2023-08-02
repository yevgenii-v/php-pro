<?php

namespace App\Services\ArrayServices;

class SecondArrayService
{
    public function handle(array $data): int
    {
        $oddNumbers = [];

        foreach ($data as $number) {
            if ($this->isOddNumber($number) === true) {
                $oddNumbers[] = $number;
            }
        }

        return count($oddNumbers);
    }

    protected function isOddNumber($value): bool
    {
        return is_int($value) === true && $value % 2 === 1;
    }
}
