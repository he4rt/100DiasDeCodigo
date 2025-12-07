<?php

declare(strict_types=1);

namespace He4rt\IntegrationTwitterApi\DTOs;

use JsonSerializable;

readonly class HashtagEntityDTO implements JsonSerializable
{
    public function __construct(
        public string $text,
        public array $indices,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            text: $data['text'],
            indices: $data['indices'],
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'text' => $this->text,
            'indices' => $this->indices,
        ];
    }
}
