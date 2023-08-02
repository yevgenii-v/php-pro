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
            'onlyOddNumbers' => [
                'data' => [1, 3, 5, 7, 9 ],
                'expectedResult' => 5,
            ],

            'noOddNumbers' => [
                'data' => [0, 2, 4, 6, 8, 10],
                'expectedResult' => 0,
            ],

            'oddNumbersWithMixedData' => [
                'data' => ['1', 3, 'test', 6, 'a', 1],
                'expectedResult' => 2,
            ],
        ];
    }
}
