<?php

declare(strict_types=1);

namespace He4rt\User\Actions;

use App\Models\SocialiteUser;
use App\Models\User;
use Exception;
use He4rt\IntegrationTwitterApi\Endpoints\AdvancedSearch\AdvancedSearchRequest;
use He4rt\IntegrationTwitterApi\Endpoints\AdvancedSearch\AdvancedSearchResponse;
use He4rt\IntegrationTwitterApi\Endpoints\FindTweet\FindTweetResponse;
use He4rt\IntegrationTwitterApi\TwitterApiClient;
use He4rt\Submission\Actions\CreateSubmissionAction;

use function Illuminate\Support\hours;

class RefreshUserSubmissions
{
    public function __construct(private readonly CreateSubmissionAction $createSubmissionAction) {}

    public function for(User $record): void
    {
        $socialiteUser = SocialiteUser::query()
            ->where('user_id', $record->getKey())
            ->where('provider', 'twitter')
            ->whereNotNull('username')
            ->first();

        if (!$socialiteUser) {
            return;
        }

        $payload = $this->buildAdvancedSearchPayload($socialiteUser->username);
        $response = $this->fetchTweetsFromAdvanceSearch($socialiteUser->username, $payload);

        if ($response->tweets === []) {
            $response = $this->fetchTweetsFromUser($socialiteUser->provider_id);
        }

        foreach ($response->tweets as $tweet) {
            $this->createSubmissionAction->for($socialiteUser->user, $tweet);
        }
    }

    /**
     * @throws Exception
     */
    private function fetchTweetsFromAdvanceSearch(string $username, string $payload): AdvancedSearchResponse
    {
        $client = resolve(TwitterApiClient::class);

        /** @var AdvancedSearchResponse */
        return cache()->remember(
            sprintf('refresh_%s_%s', $username, now()->addDay()->format('Y-m-d')),
            hours(10),
            fn () => $client->advancedSearch(AdvancedSearchRequest::make($payload))
        );
    }

    /**
     * @throws Exception
     */
    private function fetchTweetsFromUser(string|int $providerId): FindTweetResponse
    {
        $client = resolve(TwitterApiClient::class);

        /** @var FindTweetResponse */
        return cache()->remember(
            sprintf('refresh_%s_%s', $providerId, now()->addDay()->format('Y-m-d')),
            hours(10),
            fn () => $client->findTweetsFrom($providerId)
        );
    }

    private function buildAdvancedSearchPayload(string $username): string
    {
        if (config()->boolean('100daysofcode.advanced_query')) {
            return sprintf(
                '(from:%s) (#100DiasDeCodigo) until:%s since:2025-11-01_10:22:00_UTC',
                $username,
                now()->addDay()->format('Y-m-d')
            );
        }

        return '(from:%s) (#100DiasDeCodigo)';
    }
}
