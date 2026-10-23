<?php

declare(strict_types=1);

namespace He4rt\IntegrationTwitterApi\Endpoints\FindTweet;

use He4rt\IntegrationTwitterApi\DTOs\TweetDTO;

readonly class FindTweetResponse
{
    /**
     * @param  TweetDTO[]  $tweets
     */
    public function __construct(
        public array $tweets,
        public int $count
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
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
