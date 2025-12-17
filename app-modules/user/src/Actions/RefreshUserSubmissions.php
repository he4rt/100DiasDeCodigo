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

        if (! $socialiteUser) {
            return;
        }

        $searchUntilDate = now()->addDay()->format('Y-m-d');
        $payload = sprintf(
            '(from:%s) (#100DiasDeCodigo) until:%s since:2025-11-01_10:22:00_UTC',
            $socialiteUser->username,
            $searchUntilDate
        );
        $response = $this->fetchTweetsFromAdvanceSearch($searchUntilDate, $socialiteUser->username, $payload);

        if ($response->tweets === []) {
            $response = $this->fetchTweetsFromUser($searchUntilDate, $socialiteUser->provider_id);
        }

        foreach ($response->tweets as $tweet) {
            $this->createSubmissionAction->for($socialiteUser->user, $tweet);
        }
    }

    /**
     * @throws Exception
     */
    private function fetchTweetsFromAdvanceSearch(string $searchUntilDate, string $username, string $payload): AdvancedSearchResponse
    {
        $client = resolve(TwitterApiClient::class);

        /** @var AdvancedSearchResponse */
        return cache()->remember(
            sprintf('refresh_%s_%s', $username, $searchUntilDate),
            hours(10),
            fn () => $client->advancedSearch(AdvancedSearchRequest::make($payload))
        );
    }

    /**
     * @throws Exception
     */
    private function fetchTweetsFromUser(string $searchUntilDate, string|int $providerId): FindTweetResponse
    {
        $client = resolve(TwitterApiClient::class);

        /** @var FindTweetResponse */
        return cache()->remember(
            sprintf('refresh_%s_%s', $providerId, $searchUntilDate),
            hours(10),
            fn () => $client->findTweetsFrom($providerId)
        );
    }
}
