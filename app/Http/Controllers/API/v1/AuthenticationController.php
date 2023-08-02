<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\LoginRequest;
use App\Http\Requests\Authentication\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Repositories\Users\RegisterDTO;
use App\Services\Users\UserAuthService;
use App\Services\Users\UserLoginService;
use App\Services\Users\UserRegisterService;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthenticationController extends Controller
{
    public function __construct(
        protected UserLoginService $userLoginService,
        protected UserAuthService $userAuthService,
        protected UserRegisterService $authRegisterService
    ) {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $dto = new RegisterDTO(...$request->validated());
        $service = $this->authRegisterService->register($dto);
        $resource = new UserResource($service);

        return $resource->response()->setStatusCode(201);
    }

    public function login(LoginRequest $request): Application|Response|JsonResponse
    {
        $data = $request->validated();
        $user = $this->userLoginService->login($data);

        if (is_null($user) === true) {
            return response(['error' => 'Credentials has not match']);
        }

        $bearerToken = $this->userAuthService->createUserToken();
        $resource = new UserResource($user);

        return $resource->additional([
            'Bearer' => $bearerToken,
        ])->response()->setStatusCode(200);
    }

    public function profile(): JsonResponse
    {
        $userId = $this->userAuthService->getUserId();
        $user = $this->authRegisterService->getUserById($userId);

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
