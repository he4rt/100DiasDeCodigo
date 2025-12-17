<?php

declare(strict_types=1);

namespace He4rt\IntegrationTwitterApi\Actions;

use He4rt\IntegrationTwitterApi\Endpoints\Webhook\TwitterWebhookResponse;
use He4rt\Submission\Actions\CreateSubmissionAction;

readonly class TwitterBatchProcessorAction
{
    public function __construct(
        private CreateSubmissionAction $createSubmissionAction
    ) {}

    public function batch(TwitterWebhookResponse $payload): void
    {
        foreach ($payload->tweets as $tweet) {
            $this->createSubmissionAction->for(
                user: null,
                tweet: $tweet
            );
        }
    }
}
