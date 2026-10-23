<?php

declare(strict_types=1);

namespace He4rt\IntegrationTwitterApi\Actions;

use He4rt\IntegrationTwitterApi\Endpoints\Webhook\TwitterWebhookResponse;
use He4rt\Submission\Actions\CreateSubmissionAction;

final readonly class TwitterBatchProcessorAction
{
    public function __construct(
        private CreateSubmissionAction $createSubmissionAction
    ) {}

    public function handle(TwitterWebhookResponse $payload): void
    {
        foreach ($payload->tweets as $tweet) {
            $this->createSubmissionAction->handle(
                user: null,
                tweet: $tweet
            );
        }
    }
}
