<?php

declare(strict_types=1);

namespace He4rt\IntegrationTwitterApi\DTOs;

use JsonSerializable;

readonly class TimelineResponse implements JsonSerializable
{
    /**
     * @param  TweetDTO[]  $tweets
     */
    public function __construct(
        public array $tweets,
        public bool $hasNextPage,
        public ?string $nextCursor,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            tweets: array_map(
                TweetDTO::fromArray(...),
                $data['tweets'] ?? []
            ),
            hasNextPage: $data['has_next_page'],
            nextCursor: $data['next_cursor'] ?? null,
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'tweets' => array_map(fn (TweetDTO $tweet) => $tweet->jsonSerialize(), $this->tweets),
            'has_next_page' => $this->hasNextPage,
            'next_cursor' => $this->nextCursor,
        ];
    }
}
