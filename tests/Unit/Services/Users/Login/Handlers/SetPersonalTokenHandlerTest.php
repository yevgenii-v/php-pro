<?php

namespace Tests\Unit\Services\Users\Login\Handlers;

use App\Services\Users\Login\Handlers\SetPersonalTokenHandler;
use App\Services\Users\Login\LoginDTO;
use App\Services\Users\UserAuthService;
use Laravel\Passport\PersonalAccessTokenResult;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class SetPersonalTokenHandlerTest extends TestCase
{

    protected UserAuthService $userAuthService;
    protected LoginDTO $loginDTO;
    protected PersonalAccessTokenResult $token;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loginDTO = $this->createMock(LoginDTO::class);
        $this->userAuthService = $this->createMock(UserAuthService::class);
        $this->token = $this->createMock(PersonalAccessTokenResult::class);
    }

    public function testHandle(): void
    {
        $this->userAuthService
            ->expects(self::once())
            ->method('createUserToken')
            ->willReturn($this->token);

        $this->loginDTO
            ->expects(self::once())
            ->method('setBearerToken')
            ->with(self::equalTo($this->token));

        $setPersonalTokenHandler = new SetPersonalTokenHandler($this->userAuthService);

        $result = $setPersonalTokenHandler->handle($this->loginDTO, function ($loginDTO) {
            return $loginDTO;
        });

        $this->assertEquals($result, $this->loginDTO);
    }
}
