<?php

namespace App\Http\Middleware;

use App\Helpers\Api\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()->hasActiveSubscription()) {
            return ApiResponse::Fail(403,'نیاز به اشتراک فعال');
        }

        return $next($request);
    }
}
