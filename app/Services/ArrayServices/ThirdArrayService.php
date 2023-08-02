<?php

namespace App\Services\ArrayServices;

class ThirdArrayService
{
    public function handle(array $data): int
    {
        $lessThenTen = [];

        foreach ($data as $number) {
            if ($number < 10) {
                $lessThenTen[] = $number;
            }
        }

        return count($lessThenTen);
    }
}
