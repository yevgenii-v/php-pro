<?php

namespace Tests\Unit\Services;

use App\Services\Books\BookCounterService;
use PHPUnit\Framework\TestCase;

class BookCounterServiceTest extends TestCase
{
    protected BookCounterService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = new BookCounterService();
    }

    /**
     * @dataProvider handleProvider
     */
    public function testBookCounter(int $id, array $array, array $expected): void
    {
        $result = $this->service->handle($id, $array);

        $this->assertSame($result, $expected);
    }

    public static function handleProvider(): array
    {
        return [
            'validData' => [
                'id'        => 123,
                'array'     => [456 => 3, 789 => 5],
                'expected'  => [456 => 3, 789 => 5, 123 => 1],
            ]
        ];
    }
}
