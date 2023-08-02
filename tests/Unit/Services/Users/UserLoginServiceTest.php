<?php

namespace Tests\Unit\Services\Users;

use App\Repositories\Users\Iterators\UserIterator;
use App\Repositories\Users\UserRepository;
use App\Services\Users\UserAuthService;
use App\Services\Users\UserLoginService;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class UserLoginServiceTest extends TestCase
{

    protected UserLoginService $userLoginService;
    protected UserAuthService $userAuthService;
    protected UserRepository $userRepository;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository  = $this->createMock(UserRepository::class);
        $this->userAuthService = $this->createMock(UserAuthService::class);
        $this->userLoginService = new UserLoginService(
            $this->userRepository,
            $this->userAuthService,
        );
    }

    public function testValidLogin()
    {
        $data = ['email' => 'test@test.loc', 'password' => 'secret'];
        $userId = 1;

        $this->userAuthService
            ->expects(self::once())
            ->method('isCorrectUserData')
            ->with($data)
            ->willReturn(true);

        $userIterator = new UserIterator(
            (object)[
                'id'        => $userId,
                'name'      => 'test',
                'email'     => 'test@test.loc',
                'createdAt' => now()
            ]
        );

        $this->userAuthService
            ->expects(self::once())
            ->method('getUserId')
            ->willReturn($userId);

        $this->userRepository
            ->expects(self::once())
            ->method('getUserById')
            ->willReturn($userIterator);

        $result = $this->userLoginService->login($data);

        $this->assertSame($userIterator, $result);
    }


    public function testInvalidLogin()
    {
        $data = ['email' => 'test2@test.loc', 'password' => 'secret'];

        $this->userAuthService
            ->expects(self::once())
            ->method('isCorrectUserData')
            ->with($data)
            ->willReturn(false);

        $result = $this->userLoginService->login($data);

        $this->assertNull($result);
    }
}
