<?php

namespace Tests\Unit\Services\ArrayServices;

use App\Services\ArrayServices\SecondArrayService;
use PHPUnit\Framework\TestCase;

class SecondArrayServiceTest extends TestCase
{

    protected SecondArrayService $secondArrayService;

    /**
     * A basic unit test example.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->secondArrayService = new SecondArrayService();
    }

    /**
     * @dataProvider handleProvider
     */
    public function testHandle(array $data, int $expectedResult): void
    {
        $filteredData = $this->secondArrayService->handle($data);

        $this->assertEquals($expectedResult, $filteredData);
    }

    public static function handleProvider(): array
    {
        return [
            [[0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10], 5],
            [[0, 2, 4, 6, 8, 10], 0],
            [['1', 3, 'test', 6, 'a', 1], 2],
        ];
    }
}
