<?php

namespace App\Http\Middleware\API;

use App\Enums\RequestMethod;
use App\Events\UserRouteActionEvent;
use App\Repositories\UserRouteAction\UserRouteActionStoreDTO;
use App\Services\UserRouteActionService;
use App\Services\Users\UserAuthService;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GetUserAction
{
    public function __construct(
        protected UserAuthService $userAuthService,
        protected UserRouteActionService $userRouteActionService,
    ) {
    }

    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->userAuthService->authCheck() === true) {
            $DTO = new UserRouteActionStoreDTO(
                $this->userAuthService->getUserId(),
                RequestMethod::from($request->method()),
                $request->route()->getName(),
                Carbon::now()
            );

            $this->userRouteActionService->store($DTO);
            UserRouteActionEvent::dispatch($DTO);

            return $next($request);
        }

        return response(['error' => 'Unauthorized'])->setStatusCode(401);
    }
}
