<?php

declare(strict_types=1);

namespace He4rt\IntegrationTwitterApi\Endpoints\Webhook;

use He4rt\IntegrationTwitterApi\DTOs\TweetDTO;

class TwitterWebhookResponse
{
    /**
     * @param  TweetDTO[]  $tweets
     */
    public function __construct(
        public array $tweets,
        public int $count
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            tweets: array_map(
                TweetDTO::fromArray(...),
                $data['tweets'] ?? []
            ),
            count: count($data['tweets'] ?? [])
        );
    }

    public function getFirstTweet(): TweetDTO
    {
        return $this->tweets[0];
    }

    public function empty(): bool
    {
        return $this->count === 0;
    }
}
