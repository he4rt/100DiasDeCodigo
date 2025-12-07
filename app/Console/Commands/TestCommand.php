<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use He4rt\IntegrationTwitterApi\Endpoints\AdvancedSearch\AdvancedSearchRequest;
use He4rt\IntegrationTwitterApi\TwitterApiClient;
use He4rt\Submission\Enums\SubmissionStatus;
use He4rt\Submission\Models\Submission;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(TwitterApiClient $client): int
    {

        $response = $client->advancedSearch(AdvancedSearchRequest::make('(from:danielhe4rt) (#100DiasDeCodigo) until:2025-12-07 since:2025-11-06_10:22:00_UTC'));

        foreach ($response->tweets as $tweet) {

            $user = User::query()->where('username', $tweet->author->userName)->first();

            Submission::query()->create([
                'user_id' => $user?->getKey(),
                'content' => $tweet->text,
                'tweet_id' => $tweet->id,
                'status' => SubmissionStatus::Pending,
                'metadata' => $tweet->jsonSerialize(),
                'submitted_at' => Date::parse($tweet->createdAt)->timezone(config('app.timezone')),
            ]);
        }

        return self::SUCCESS;
    }
}
