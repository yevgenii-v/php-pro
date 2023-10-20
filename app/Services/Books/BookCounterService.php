<?php

namespace App\Services\Books;

class BookCounterService
{
    /**
     * @param int $bookId
     * @param array $array
     * @return array
     */
    public function handle(int $bookId, array $array): array
    {
        $result = [];
        if (array_key_exists($bookId, $array) === false) {
            $array[$bookId] = 0;
        }

        foreach ($array as $key => $value) {
            if ($key === $bookId) {
                $value++;
            }
            $result[$key] = $value;
        }
        return $result;
    }
}
