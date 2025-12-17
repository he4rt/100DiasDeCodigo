<?php

declare(strict_types=1);

use App\Models\SocialiteUser;
use Basement\Webhooks\Models\InboundWebhook;
use He4rt\IntegrationTwitterApi\Tests\Entities\TweetDTOFactory;
use He4rt\Submission\Models\Submission;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;

it('can process twitter webhook', function (): void {
    $mockedData = [
        'tweet_id' => '2001233687787012177',
        'user_id' => '1103420181139935234',
        'content' => 'Hello World #100DiasDeCodigo',
    ];
    SocialiteUser::factory()->create([
        'provider' => 'twitter',
        'provider_id' => $mockedData['user_id'],
    ]);

    config(['services.twitter.api_key' => '123']);

    $payload = [
        'tweets' => [
            TweetDTOFactory::with($mockedData['tweet_id'], $mockedData['user_id'], $mockedData['content']),
        ],
        'rule_id' => '043639e79d424c7494736c58f5bb7083',
        'rule_tag' => 'tag',
        'rule_value' => '(#100DiasDeCodigo)',
        'event_type' => 'tweet',
        'timestamp' => 1765996281150,
    ];

    $this->postJson(
        uri: route('twitter.webhook'),
        data: $payload,
        headers: ['X-API-Key' => '123']
    )->assertNoContent();

    assertDatabaseHas(Submission::class, [
        'tweet_id' => '2001233687787012177',
    ]);

    assertDatabaseCount(InboundWebhook::class, 1);
});

it('can process twitter webhook but skip if tweet doesnt have the tag', function (): void {
    config(['services.twitter.api_key' => '123']);
    $mockedData = [
        'tweet_id' => '2001233687787012177',
        'user_id' => '1103420181139935234',
        'content' => 'Hello World',
    ];

    SocialiteUser::factory()->create([
        'provider' => 'twitter',
        'provider_id' => '1103420181139935234',
    ]);

    $payload = [
        'tweets' => [
            TweetDTOFactory::with($mockedData['tweet_id'], $mockedData['user_id'], $mockedData['content']),
        ],
        'rule_id' => '043639e79d424c7494736c58f5bb7083',
        'rule_tag' => 'tag',
        'rule_value' => '(#100DiasDeCodigo)',
        'event_type' => 'tweet',
        'timestamp' => 1765996281150,
    ];

    $this->postJson(
        uri: route('twitter.webhook'),
        data: $payload,
        headers: ['X-API-Key' => '123']
    )->assertNoContent();

    assertDatabaseCount(Submission::class, 0);
    assertDatabaseCount(InboundWebhook::class, 1);
});

it('cannot process twitter webhook with wrong key', function (): void {
    config(['services.twitter.api_key' => 'foda-se']);
    $mockedData = [
        'tweet_id' => '2001233687787012177',
        'user_id' => '1103420181139935234',
        'content' => 'Hello World',
    ];

    SocialiteUser::factory()->create([
        'provider' => 'twitter',
        'provider_id' => '1103420181139935234',
    ]);

    $payload = [
        'tweets' => [
            TweetDTOFactory::with($mockedData['tweet_id'], $mockedData['user_id'], $mockedData['content']),
        ],
        'rule_id' => '043639e79d424c7494736c58f5bb7083',
        'rule_tag' => 'tag',
        'rule_value' => '(#100DiasDeCodigo)',
        'event_type' => 'tweet',
        'timestamp' => 1765996281150,
    ];

    $this->postJson(
        uri: route('twitter.webhook'),
        data: $payload,
        headers: ['X-API-Key' => 'lol']
    )->assertUnauthorized();

    assertDatabaseCount(Submission::class, 0);
    assertDatabaseCount(InboundWebhook::class, 0);
});
