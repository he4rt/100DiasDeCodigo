<?php

declare(strict_types=1);

namespace He4rt\Submission\Casts;

use He4rt\IntegrationTwitterApi\DTOs\TweetDTO;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Database\Eloquent\SerializesCastableAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * @implements CastsAttributes<TweetDTO|null, TweetDTO|array<string, mixed>|null>
 */
final class AsTweet implements CastsAttributes, SerializesCastableAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?TweetDTO
    {
        if ($value === null) {
            return null;
        }

        /** @var array<string, mixed> $payload */
        $payload = json_decode((string) $value, associative: true, flags: JSON_THROW_ON_ERROR);

        return TweetDTO::fromArray($payload);
    }

    /**
     * @param  TweetDTO|array<string, mixed>|null  $value
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        $tweet = $value === null || $value instanceof TweetDTO ? $value : TweetDTO::fromArray($value);

        return $tweet instanceof TweetDTO ? json_encode($tweet, JSON_THROW_ON_ERROR) : null;
    }

    /**
     * @param  TweetDTO|null  $value
     * @return array<string, mixed>|null
     */
    public function serialize(Model $model, string $key, mixed $value, array $attributes): ?array
    {
        return $value?->jsonSerialize();
    }
}
