<?php

declare(strict_types=1);

namespace He4rt\IntegrationTwitterApi\DTOs;

use JsonSerializable;

readonly class EntitiesDTO implements JsonSerializable
{
    /**
     * @param  HashtagEntityDTO[]  $hashtags
     * @param  UrlEntityDTO[]  $urls
     * @param  UserMentionEntityDTO[]  $userMentions
     * @param  MediaEntityDTO[]  $media
     */
    public function __construct(
        public array $hashtags,
        public array $urls,
        public array $userMentions,
        public array $media = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            hashtags: array_map(
                HashtagEntityDTO::fromArray(...),
                $data['hashtags'] ?? []
            ),
            urls: array_map(
                UrlEntityDTO::fromArray(...),
                $data['urls'] ?? []
            ),
            userMentions: array_map(
                UserMentionEntityDTO::fromArray(...),
                $data['user_mentions'] ?? []
            ),
            media: array_map(
                MediaEntityDTO::fromArray(...),
                $data['media'] ?? []
            ),
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'hashtags' => array_map(fn (HashtagEntityDTO $dto) => $dto->jsonSerialize(), $this->hashtags),
            'urls' => array_map(fn (UrlEntityDTO $dto) => $dto->jsonSerialize(), $this->urls),
            'user_mentions' => array_map(fn (UserMentionEntityDTO $dto) => $dto->jsonSerialize(), $this->userMentions),
            'media' => array_map(fn (MediaEntityDTO $dto) => $dto->jsonSerialize(), $this->media),
        ];
    }

    public function containsHashtag(string $hashtag): bool
    {
        $hashtag = str($hashtag)
            ->replace('#', '')
            ->lower()
            ->toString();

        return collect($this->hashtags)
            ->contains(fn (HashtagEntityDTO $entity) => mb_strtolower($entity->text) === $hashtag);
    }
}
