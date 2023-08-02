<?php

namespace Tests\Unit\Services\ArrayServices;

use App\Services\ArrayServices\FirstArrayService;
use PHPUnit\Framework\TestCase;

class FirstArrayServiceTest extends TestCase
{
    protected FirstArrayService $firstArrayService;

    public function setUp(): void
    {
        parent::setUp();
        $this->firstArrayService = new FirstArrayService();
    }

    /**
     * @dataProvider handleProvider
     */
    public function testHandle(array $data, int $expectedResult)
    {
        $filteredData = $this->firstArrayService->handle($data);

        $this->assertSame($expectedResult, $filteredData);
    }

    public static function handleProvider(): array
    {
        return [
            [[0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10], 6],
            [[1, 3, 5, 7, 9], 0],
            [['1', 'test', 4, 'a', 0, 6], 3],
        ];
    }
}
