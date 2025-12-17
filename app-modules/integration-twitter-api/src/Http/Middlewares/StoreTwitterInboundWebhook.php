<?php

declare(strict_types=1);

namespace He4rt\IntegrationTwitterApi\Http\Middlewares;

use App\Enums\InboundWebhookSource;
use Basement\Webhooks\Actions\StoreInboundWebhook;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StoreTwitterInboundWebhook
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        resolve(StoreInboundWebhook::class)->store(
            source: InboundWebhookSource::TwitterApi,
            event: 'tweets',
            url: $request->url(),
            payload: $request->all()
        );

        return $next($request);
    }
}
