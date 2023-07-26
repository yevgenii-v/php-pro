<?php

namespace App\Http\Middleware\API;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth('api')->check() === false) {
            return $next($request);
        }

        return response()->json(['error' => 'You are logged in already'])
            ->setStatusCode(200);
    }
}
