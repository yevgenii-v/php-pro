<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\LoginRequest;
use App\Http\Requests\Authentication\RegisterRequest;
use App\Http\Resources\Authentication\RegisteredUserResource;
use App\Http\Resources\LoginResource;
use App\Repositories\Authentication\RegisterDTO;
use App\Services\AuthenticationService;
use Illuminate\Http\JsonResponse;

class AuthenticationController extends Controller
{
    public function __construct(
        protected AuthenticationService $authenticationService,
    ) {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $dto = new RegisterDTO(...$request->validated());
        $service = $this->authenticationService->register($dto);
        $resource = new RegisteredUserResource($service);

        return $resource->response()->setStatusCode(201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $bearerToken = $this->authenticationService->getBearerToken($request);
        $user = $this->authenticationService->getUserById($bearerToken->token->user_id);
        $resource = new LoginResource($user);

        return $resource->additional([
            'Bearer' => $bearerToken,
        ])->response()->setStatusCode(200);
    }

    public function profile(): JsonResponse
    {
        $user = $this->authenticationService->getUserById(auth()->user()->id);
        $resource = new RegisteredUserResource($user);

        return $resource->response()->setStatusCode(200);
    }

    public function logout(): JsonResponse
    {
        $user = auth()->user()->token();
        $user->revoke();

        return response()->json(['message' => 'User was logged out.'])->setStatusCode(200);
    }
}
