<?php

namespace Tests\Unit\Services\Users\Login\Handlers;

use App\Services\Users\Login\Handlers\CheckValidDataHandler;
use App\Services\Users\Login\LoginDTO;
use App\Services\Users\UserAuthService;
use PHPUnit\Framework\TestCase;

class CheckValidDataHandlerTest extends TestCase
{
    protected UserAuthService $userAuthService;
    protected CheckValidDataHandler $checkValidDataHandler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userAuthService = $this->createMock(UserAuthService::class);
        $this->checkValidDataHandler = new CheckValidDataHandler(
            $this->userAuthService
        );
    }

    public function testValidData(): void
    {
        $loginDto = new LoginDTO('test@test.loc', 'secret');

        $this->userAuthService
            ->expects(self::once())
            ->method('isCorrectUserData')
            ->willReturn(true);


        $result = $this->checkValidDataHandler
            ->handle($loginDto, function ($loginDto) {
//                echo 'closure $next works';
                return $loginDto;
            });

        $this->assertSame($result, $loginDto);
    }


    public function testInvalidData()
    {
        $loginDto = new LoginDTO('test2@test.loc', 'secret');

        $this->userAuthService
            ->expects(self::once())
            ->method('isCorrectUserData')
            ->willReturn(false);


        $result = $this->checkValidDataHandler
            ->handle($loginDto, function ($loginDto) {
                return $loginDto;
            });

        $this->assertSame($result, $loginDto);
    }
}
