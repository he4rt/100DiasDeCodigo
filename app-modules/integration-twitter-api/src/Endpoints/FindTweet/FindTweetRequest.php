<?php

declare(strict_types=1);

namespace He4rt\IntegrationTwitterApi\Endpoints\FindTweet;

use JsonSerializable;

final readonly class FindTweetRequest implements JsonSerializable
{
    /**
     * @param  string[]  $tweetIds
     */
    public function __construct(
        public array $tweetIds,
    ) {}

    public static function fromId(string|int $tweetId): self
    {
        return new self([$tweetId]);
    }

    public static function from(array $tweetIds): self
    {
        return new self($tweetIds);
    }

    public function jsonSerialize(): array
    {
        return [
            'tweet_ids' => implode(',', $this->tweetIds),
        ];
    }
}
