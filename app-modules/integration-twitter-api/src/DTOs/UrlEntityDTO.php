<?php

declare(strict_types=1);

namespace He4rt\IntegrationTwitterApi\DTOs;

use JsonSerializable;

readonly class UrlEntityDTO implements JsonSerializable
{
    public function __construct(
        public string $url,
        public string $displayUrl,
        public string $expandedUrl,
        public array $indices,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            url: $data['url'],
            displayUrl: $data['display_url'],
            expandedUrl: $data['expanded_url'],
            indices: $data['indices'],
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'url' => $this->url,
            'display_url' => $this->displayUrl,
            'expanded_url' => $this->expandedUrl,
            'indices' => $this->indices,
        ];
    }
}
