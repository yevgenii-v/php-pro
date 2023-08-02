<?php

namespace Tests\Unit\Services\ArrayServices;

use App\Services\ArrayServices\ForthArrayService;
use PHPUnit\Framework\TestCase;

class ForthArrayServiceTest extends TestCase
{

    protected ForthArrayService $forthArrayService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->forthArrayService = new ForthArrayService();
    }

    /**
     * @dataProvider handleProvider
     */
    public function testHandle(array $data, int $expectedResult): void
    {
        $filteredData = $this->forthArrayService->handle($data);

        $this->assertSame($expectedResult, $filteredData);
    }

    public static function handleProvider(): array
    {
        return [
            [[15, 1, 25, 26, 21, 72, 48, 80, 96, 89, 0, 100, 28, 10], 7],
            [['afs', '14', 26, '72', '30', 82, 90, 91], 3]
        ];
    }
}
