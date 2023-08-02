<?php

namespace Tests\Unit\Services\ArrayServices;

use App\Services\ArrayServices\ThirdArrayService;
use PHPUnit\Framework\TestCase;

class ThirdArrayServiceTest extends TestCase
{

    protected ThirdArrayService $thirdArrayService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->thirdArrayService = new ThirdArrayService();
    }

    /**
     * @dataProvider handleProvider
     */
    public function testExample(array $data, int $expectedResult): void
    {
        $filteredData = $this->thirdArrayService->handle($data);

        $this->assertSame($expectedResult, $filteredData);
    }

    public static function handleProvider(): array
    {
        return [
            'chooseLessThenTen' => [
                'data' => [1, 4, 15, 25, 2, 88, 7, 100, 2],
                'expectedResult' => 5
            ],

            'chooseLessThenTenWithMixedData' => [
                'data' => ['10', 'a', 0, 10, 25, 6, 1],
                'expectedResult' => 3
            ],
        ];
    }
}
