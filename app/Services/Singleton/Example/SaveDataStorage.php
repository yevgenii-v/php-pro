<?php

namespace App\Services\Singleton\Example;

/**
 * WARNING: This class registered as Singleton in AppServiceProvider or here.
 */
class SaveDataStorage
{
    private static ?SaveDataStorage $instance = null;

    public static function getInstance(): static
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Prohibit creating new Object of that class.
     */
    private function __construct(
        //
    ) {
    }

    protected int $count = 0;

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }

}
