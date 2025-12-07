<?php

declare(strict_types=1);

namespace He4rt\IntegrationTwitterApi\DTOs;

use JsonSerializable;

readonly class MediaEntityDTO implements JsonSerializable
{
    public function __construct(
        public string $idStr,
        public string $mediaUrlHttps,
        public string $type,
        public string $url,
        public string $displayUrl,
        public string $expandedUrl,
        public array $indices,
        public ?string $mediaKey,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            idStr: $data['id_str'],
            mediaUrlHttps: $data['media_url_https'],
            type: $data['type'],
            url: $data['url'],
            displayUrl: $data['display_url'],
            expandedUrl: $data['expanded_url'],
            indices: $data['indices'],
            mediaKey: $data['media_key'] ?? null,
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'id_str' => $this->idStr,
            'media_url_https' => $this->mediaUrlHttps,
            'type' => $this->type,
            'url' => $this->url,
            'display_url' => $this->displayUrl,
            'expanded_url' => $this->expandedUrl,
            'indices' => $this->indices,
            'media_key' => $this->mediaKey,
        ];
    }
}
