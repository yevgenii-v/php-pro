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
            'onlyEvenNumbers' => [
                'data' => [0, 2, 4, 6, 8, 10],
                'expectedResult' => 6,
            ],

            'noEvenNumbers' => [
                'data' => [1, 3, 5, 7, 9],
                'expectedResult' => 0,
            ],

            'evenNumbersWithMixedData' => [
                'data' => ['1', 'test', 4, 'a', 0, 6],
                'expectedResult' => 3,
            ],
        ];
    }
}
