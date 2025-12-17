<?php

declare(strict_types=1);

namespace He4rt\Submission\Actions;

use App\Models\User;
use He4rt\IntegrationTwitterApi\DTOs\TweetDTO;
use He4rt\Submission\Enums\SubmissionStatus;
use He4rt\Submission\Models\Submission;
use Illuminate\Support\Facades\Date;

class CreateSubmissionAction
{
    public function for(?User $user, TweetDTO $tweet): void
    {
        $isPropaganda = str($tweet->text)->lower()->doesntContain('100diasdecodigo');

        if ($isPropaganda) {
            return;
        }

        $submission = Submission::query()->where('tweet_id', $tweet->id)->first();

        if (! $submission) {
            Submission::query()->create([
                'user_id' => $user?->getKey() ?? null,
                'content' => $tweet->text,
                'tweet_id' => $tweet->id,
                'status' => SubmissionStatus::Pending,
                'metadata' => $tweet->jsonSerialize(),
                'submitted_at' => Date::parse($tweet->createdAt)->timezone(config('app.timezone')),
            ]);

            return;
        }

        $submission->update([
            'content' => $tweet->text,
            'metadata' => $tweet->jsonSerialize(),
            'submitted_at' => Date::parse($tweet->createdAt)->timezone(config('app.timezone')),
        ]);
    }
}
