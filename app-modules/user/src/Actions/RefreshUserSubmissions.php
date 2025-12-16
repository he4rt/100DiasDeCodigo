<?php

declare(strict_types=1);

namespace He4rt\User\Actions;

use App\Models\SocialiteUser;
use App\Models\User;
use Exception;
use He4rt\IntegrationTwitterApi\Endpoints\AdvancedSearch\AdvancedSearchRequest;
use He4rt\IntegrationTwitterApi\Endpoints\AdvancedSearch\AdvancedSearchResponse;
use He4rt\IntegrationTwitterApi\TwitterApiClient;
use He4rt\Submission\Enums\SubmissionStatus;
use He4rt\Submission\Models\Submission;
use Illuminate\Support\Facades\Date;

use function Illuminate\Support\hours;

class RefreshUserSubmissions
{
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
        $response = $this->fetchTweets($searchUntilDate, $socialiteUser->username, $payload);

        foreach ($response->tweets as $tweet) {

            $isPropaganda = str($tweet->text)->lower()->doesntContain('100diasdecodigo');
            if ($isPropaganda) {
                continue;
            }

            $submission = Submission::query()->where('tweet_id', $tweet->id)->first();

            if (! $submission) {
                Submission::query()->create([
                    'user_id' => $socialiteUser->user_id,
                    'content' => $tweet->text,
                    'tweet_id' => $tweet->id,
                    'status' => SubmissionStatus::Pending,
                    'metadata' => $tweet->jsonSerialize(),
                    'submitted_at' => Date::parse($tweet->createdAt)->timezone(config('app.timezone')),
                ]);

                continue;
            }

            $submission->update([
                'content' => $tweet->text,
                'metadata' => $tweet->jsonSerialize(),
                'submitted_at' => Date::parse($tweet->createdAt)->timezone(config('app.timezone')),
            ]);
        }
    }

    /**
     * @throws Exception
     */
    private function fetchTweets(string $searchUntilDate, string $username, string $payload): AdvancedSearchResponse
    {
        $client = resolve(TwitterApiClient::class);

        /** @var AdvancedSearchResponse */
        return cache()->remember(
            sprintf('refresh_%s_%s', $username, $searchUntilDate),
            hours(10),
            fn () => $client->advancedSearch(AdvancedSearchRequest::make($payload))
        );
    }
}
