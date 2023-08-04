<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\LoginRequest;
use App\Http\Requests\Authentication\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Repositories\Users\RegisterDTO;
use App\Services\Users\Login\LoginDTO;
use App\Services\Users\Login\LoginService;
use App\Services\Users\UserAuthService;
use App\Services\Users\UserService;
use App\Services\Users\UserRegisterService;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthenticationController extends Controller
{
    public function __construct(
        protected UserAuthService $userAuthService,
    ) {
    }

    public function register(RegisterRequest $request, UserRegisterService $authRegisterService): JsonResponse
    {
        $dto = new RegisterDTO(...$request->validated());
        $service = $authRegisterService->register($dto);
        $resource = new UserResource($service);

        return $resource->response()->setStatusCode(201);
    }

    public function login(LoginRequest $request, LoginService $loginService): Application|Response|JsonResponse
    {
        $data = $request->validated();

        $loginDTO = new LoginDTO(...$data);
        $user = $loginService->handle($loginDTO);

        $resource = new UserResource($user->getUser());
        $bearerToken = $user->getBearerToken();


        return $resource->additional([
            'Bearer' => $bearerToken,
        ])->response()->setStatusCode(200);
    }

    public function profile(UserService $userService): JsonResponse
    {
        $userId = $this->userAuthService->getUserId();
        $user = $userService->getById($userId);

        $resource = new UserResource($user);

        return $resource->response()->setStatusCode(200);
    }

    public function logout(): JsonResponse
    {
        $userToken = $this->userAuthService->getUserToken();
        $userToken->revoke();

        return response()->json(['message' => 'User was logged out.'])->setStatusCode(200);
    }
}
