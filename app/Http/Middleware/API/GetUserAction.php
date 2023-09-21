<?php

namespace App\Http\Middleware\API;

use App\Enums\RequestMethod;
use App\Events\UserRouteActionEvent;
use App\Http\Middleware\Authenticate;
use App\Repositories\UserRouteAction\UserRouteActionStoreDTO;
use App\Services\UserRouteActionService;
use App\Services\Users\UserAuthService;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): Response
    {
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
}
