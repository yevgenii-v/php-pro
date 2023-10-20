<?php

namespace App\Services\Books;

use App\Services\Books\Storages\BookCommentsCounterStorage;

class CountBookViewsService
{
    private const BASIC_COUNT_VALUE = 1;
    public function __construct(
        protected BookCommentsCounterStorage $storage,
        protected BookCounterService $service,
    ) {
    }

    public function handle(int $bookId): void
    {
        $array = [];

        if ($this->storage->exists() === true) {
            $result = $this->service->handle($bookId, json_decode($this->storage->get(), true));
            $this->storage->set(json_encode($result));
            return;
        }

        $array[$bookId] = self::BASIC_COUNT_VALUE;
        $this->storage->set(json_encode($array));
    }
}
