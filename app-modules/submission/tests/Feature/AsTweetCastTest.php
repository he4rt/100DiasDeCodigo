<?php

declare(strict_types=1);

use He4rt\IntegrationTwitterApi\DTOs\TweetDTO;
use He4rt\Submission\Models\Submission;

it('reads the stored metadata as a tweet', function (): void {
    $submission = Submission::factory()->create();

    expect($submission->refresh()->metadata)->toBeInstanceOf(TweetDTO::class);
});

it('stores a tweet and reads back the same payload', function (): void {
    $tweet = Submission::factory()->make()->metadata;

    $submission = Submission::factory()->create(['metadata' => $tweet]);

    expect($submission->refresh()->metadata?->jsonSerialize())->toBe($tweet?->jsonSerialize());
});

it('stores a tweet payload array as a tweet', function (): void {
    $payload = Submission::factory()->make()->metadata?->jsonSerialize();

    $submission = Submission::factory()->create(['metadata' => $payload]);

    expect($submission->refresh()->metadata?->id)->toBe($payload['id']);
});

it('serializes the tweet as its payload array', function (): void {
    $submission = Submission::factory()->create();

    expect($submission->toArray()['metadata'])->toBe($submission->metadata?->jsonSerialize());
});

it('keeps null metadata as null', function (): void {
    $submission = Submission::factory()->create(['metadata' => null]);

    expect($submission->refresh()->metadata)->toBeNull();
});

it('rejects a value that is not a tweet', function (): void {
    Submission::factory()->make(['metadata' => 'not a tweet']);
})->throws(TypeError::class);
