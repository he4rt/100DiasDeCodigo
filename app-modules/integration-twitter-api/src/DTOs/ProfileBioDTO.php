<?php

declare(strict_types=1);

namespace He4rt\IntegrationTwitterApi\DTOs;

use JsonSerializable;

readonly class ProfileBioDTO implements JsonSerializable
{
    public function __construct(
        public string $description,
        public ?ProfileBioEntitiesDTO $entities,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            description: $data['description'] ?? '',
            entities: isset($data['entities']) ? ProfileBioEntitiesDTO::fromArray($data['entities']) : null,
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'description' => $this->description,
            'entities' => $this->entities?->jsonSerialize(),
        ];
    }
}
