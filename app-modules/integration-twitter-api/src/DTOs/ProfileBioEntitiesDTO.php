<?php

declare(strict_types=1);

namespace He4rt\IntegrationTwitterApi\DTOs;

use JsonSerializable;

readonly class ProfileBioEntitiesDTO implements JsonSerializable
{
    /**
     * @param  UrlEntityDTO[]|null  $descriptionUrls
     * @param  UrlEntityDTO[]|null  $urlUrls
     */
    public function __construct(
        public ?array $descriptionUrls,
        public ?array $urlUrls,
    ) {}

    public static function fromArray(array $data): self
    {
        $descriptionUrls = isset($data['description']['urls'])
            ? array_map(UrlEntityDTO::fromArray(...), $data['description']['urls'])
            : null;

        $urlUrls = isset($data['url']['urls'])
            ? array_map(UrlEntityDTO::fromArray(...), $data['url']['urls'])
            : null;

        return new self(
            descriptionUrls: $descriptionUrls,
            urlUrls: $urlUrls,
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'description' => $this->descriptionUrls ? ['urls' => array_map(fn (UrlEntityDTO $dto) => $dto->jsonSerialize(), $this->descriptionUrls)] : null,
            'url' => $this->urlUrls ? ['urls' => array_map(fn (UrlEntityDTO $dto) => $dto->jsonSerialize(), $this->urlUrls)] : null,
        ];
    }
}
