<?php

declare(strict_types=1);

namespace He4rt\IntegrationTwitterApi\DTOs;

use JsonSerializable;

readonly class UserDTO implements JsonSerializable
{
    public function __construct(
        public string $id,
        public string $name,
        public string $userName,
        public string $profilePicture,
        public ?string $coverPicture,
        public string $description,
        public string $location,
        public int $followers,
        public int $following,
        public bool $isBlueVerified,
        public string $verifiedType,
        public bool $canDm,
        public string $createdAt,
        public int $favouritesCount,
        public int $mediaCount,
        public int $statusesCount,
        public ?ProfileBioDTO $profileBio,
        public bool $canMediaTag = false,
        public int $fastFollowersCount = 0,
        public ?string $status = null,
        public array $withheldInCountries = [],
        public array $affiliatesHighlightedLabel = [],
        public bool $possiblySensitive = false,
        public array $pinnedTweetIds = [],
        public bool $isAutomated = false,
        public ?string $automatedBy = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            userName: $data['userName'],
            profilePicture: $data['profilePicture'],
            coverPicture: $data['coverPicture'] ?? null,
            description: $data['description'] ?? '',
            location: $data['location'] ?? '',
            followers: $data['followers'],
            following: $data['following'],
            isBlueVerified: $data['isBlueVerified'],
            verifiedType: $data['verifiedType'] ?? '',
            canDm: $data['canDm'],
            createdAt: $data['createdAt'],
            favouritesCount: $data['favouritesCount'],
            mediaCount: $data['mediaCount'],
            statusesCount: $data['statusesCount'],
            profileBio: isset($data['profile_bio']) ? ProfileBioDTO::fromArray($data['profile_bio']) : null,
            canMediaTag: $data['canMediaTag'] ?? false,
            fastFollowersCount: $data['fastFollowersCount'] ?? 0,
            status: $data['status'] ?? null,
            withheldInCountries: $data['withheldInCountries'] ?? [],
            affiliatesHighlightedLabel: $data['affiliatesHighlightedLabel'] ?? [],
            possiblySensitive: $data['possiblySensitive'] ?? false,
            pinnedTweetIds: $data['pinnedTweetIds'] ?? [],
            isAutomated: $data['isAutomated'] ?? false,
            automatedBy: $data['automatedBy'] ?? null,
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'userName' => $this->userName,
            'profilePicture' => $this->profilePicture,
            'coverPicture' => $this->coverPicture,
            'description' => $this->description,
            'location' => $this->location,
            'followers' => $this->followers,
            'following' => $this->following,
            'isBlueVerified' => $this->isBlueVerified,
            'verifiedType' => $this->verifiedType,
            'canDm' => $this->canDm,
            'createdAt' => $this->createdAt,
            'favouritesCount' => $this->favouritesCount,
            'mediaCount' => $this->mediaCount,
            'statusesCount' => $this->statusesCount,
            'profile_bio' => $this->profileBio?->jsonSerialize(),
            'canMediaTag' => $this->canMediaTag,
            'fastFollowersCount' => $this->fastFollowersCount,
            'status' => $this->status,
            'withheldInCountries' => $this->withheldInCountries,
            'affiliatesHighlightedLabel' => $this->affiliatesHighlightedLabel,
            'possiblySensitive' => $this->possiblySensitive,
            'pinnedTweetIds' => $this->pinnedTweetIds,
            'isAutomated' => $this->isAutomated,
            'automatedBy' => $this->automatedBy,
        ];
    }
}
