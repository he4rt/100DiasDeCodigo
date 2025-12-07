<?php

declare(strict_types=1);

namespace He4rt\IntegrationTwitterApi\Endpoints\AdvancedSearch;

use He4rt\IntegrationTwitterApi\DTOs\TweetDTO;

final class AdvancedSearchResponse
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
}
