<?php

namespace App\Services\ArrayServices;

class FirstArrayService
{
    public function handle(array $data): int
    {
        $evenNumbers = [];

        foreach ($data as $number) {
            if ($this->isEvenNumber($number) === true) {
                $evenNumbers[] = $number;
            }
        }

        return count($evenNumbers);
    }

    protected function isEvenNumber($value): bool
    {
        return is_int($value) === true && $value % 2 === 0;
    }
}
