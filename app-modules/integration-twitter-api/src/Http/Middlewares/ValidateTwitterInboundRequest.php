<?php

declare(strict_types=1);

namespace He4rt\IntegrationTwitterApi\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateTwitterInboundRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $header = $request->header('X-API-Key');

        if (blank($header)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if ($header !== config('services.twitter.api_key')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
