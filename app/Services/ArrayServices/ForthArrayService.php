<?php

namespace App\Services\ArrayServices;

class ForthArrayService
{
    public function handle(array $data): int
    {
        $biggerAndEvenNumbers = [];

        foreach ($data as $number) {
            if ($this->isBiggerThenAndEvenNumbers($number) === true) {
                $biggerAndEvenNumbers[] = $number;
            }
        }

        return count($biggerAndEvenNumbers);
    }

    protected function isBiggerThenAndEvenNumbers($value): bool
    {
        return is_int($value) === true
            && $value > 25 === true
            && $value % 2 === 0;
    }
}
