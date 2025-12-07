<?php

declare(strict_types=1);

namespace He4rt\IntegrationTwitterApi\DTOs;

use JsonSerializable;

readonly class UserMentionEntityDTO implements JsonSerializable
{
    public function __construct(
        public string $idStr,
        public string $name,
        public string $screenName,
        public array $indices,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            idStr: $data['id_str'],
            name: $data['name'],
            screenName: $data['screen_name'],
            indices: $data['indices'],
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'id_str' => $this->idStr,
            'name' => $this->name,
            'screen_name' => $this->screenName,
            'indices' => $this->indices,
        ];
    }
}
