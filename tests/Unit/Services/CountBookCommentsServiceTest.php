<?php

namespace Tests\Unit\Services;

use App\Services\Books\BookCounterService;
use App\Services\Books\CountBookCommentsService;
use App\Services\Books\Storages\BookCommentsCounterStorage;
use PHPUnit\Framework\TestCase;

class CountBookCommentsServiceTest extends TestCase
{
    protected BookCommentsCounterStorage $bookCommentsCounterStorage;
    protected BookCounterService $counterService;
    protected CountBookCommentsService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bookCommentsCounterStorage = $this->createMock(BookCommentsCounterStorage::class);
        $this->counterService = $this->createMock(BookCounterService::class);

        $this->service = new CountBookCommentsService(
            $this->bookCommentsCounterStorage,
            $this->counterService,
        );
    }

    /**
     * @dataProvider handleProvider
     */
    public function testHandle(int $id, array $serviceResult, array $initStorageContent): void
    {
        $this->bookCommentsCounterStorage
            ->method('exists')->willReturn(true);

        $this->counterService
            ->method('handle')
            ->willReturn($serviceResult);

        $this->bookCommentsCounterStorage
            ->method('get')
            ->willReturn(json_encode($initStorageContent));

        $this->bookCommentsCounterStorage
            ->expects(self::once())
            ->method('set')
            ->with(json_encode($serviceResult));

        $this->service->handle($id);
    }

    public static function handleProvider(): array
    {
        return [
            'validData' => [
                'id'                    => 123,
                'serviceResult'         => [123 => 2],
                'initStorageContent'    => [123 => 1],
            ]
        ];
    }
}
