<?php

declare(strict_types=1);

namespace He4rt\IntegrationTwitterApi\Http\Controllers;

use He4rt\IntegrationTwitterApi\Actions\TwitterBatchProcessorAction;
use He4rt\IntegrationTwitterApi\Http\Requests\TwitterWebhookRequest;

final class TwitterWebhookController
{
    public function __invoke(TwitterWebhookRequest $request, TwitterBatchProcessorAction $action)
    {
        $action->handle($request->toDto());

        return response()->noContent();
    }
}
