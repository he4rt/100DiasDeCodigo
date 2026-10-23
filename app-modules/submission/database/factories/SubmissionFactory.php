<?php

declare(strict_types=1);

namespace He4rt\Submission\Database\Factories;

use App\Models\User;
use He4rt\Submission\Enums\SubmissionStatus;
use He4rt\Submission\Models\Submission;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

/** @extends Factory<Submission> */
final class SubmissionFactory extends Factory
{
    protected $model = Submission::class;

    public function definition(): array
    {
        return [
            'submitted_at' => fake()->dateTime(),
            'tweet_id' => fake()->uuid(),
            'metadata' => [
                'id' => fake()->uuid(),
                'text' => fake()->sentence(12),
                'createdAt' => Date::now()->format('D M d H:i:s O Y'),
                'author' => [
                    'id' => fake()->uuid(),
                    'name' => fake()->name(),
                    'userName' => fake()->userName(),
                    'profilePicture' => fake()->url(),
                    'description' => fake()->sentence(10),
                    'location' => fake()->city(),
                    'followers' => fake()->numberBetween(0, 100_000),
                    'following' => fake()->numberBetween(0, 5_000),
                    'isBlueVerified' => fake()->boolean(),
                    'verifiedType' => 'blue',
                    'canDm' => fake()->boolean(),
                    'createdAt' => Date::now()->format('D M d H:i:s O Y'),
                    'favouritesCount' => fake()->numberBetween(0, 50_000),
                    'mediaCount' => fake()->numberBetween(0, 5_000),
                    'statusesCount' => fake()->numberBetween(0, 100_000),
                    'canMediaTag' => fake()->boolean(),
                    'fastFollowersCount' => fake()->numberBetween(0, 10_000),
                    'withheldInCountries' => [],
                    'affiliatesHighlightedLabel' => [],
                    'pinnedTweetIds' => [],
                    'possiblySensitive' => false,
                    'isAutomated' => false,
                ],
                'retweetCount' => fake()->numberBetween(0, 1_000),
                'replyCount' => fake()->numberBetween(0, 300),
                'likeCount' => fake()->numberBetween(0, 5_000),
                'quoteCount' => fake()->numberBetween(0, 200),
                'viewCount' => fake()->numberBetween(100, 200_000),
                'lang' => 'pt',
                'isReply' => fake()->boolean(),
            ],

            'status' => SubmissionStatus::Pending,
            'content' => fake()->sentence(),
            'approved_at' => null,
            'created_at' => Date::now(),
            'updated_at' => Date::now(),

            'user_id' => User::factory(),
            'approver_id' => null,
        ];
    }

    public function pending(): self
    {
        return $this->state([
            'status' => SubmissionStatus::Pending,
            'approved_at' => null,
            'approver_id' => null,
        ]);
    }

    public function approved(?User $approver = null): self
    {
        return $this->state([
            'status' => SubmissionStatus::Approved,
            'approved_at' => Date::now(),
            'approver_id' => $approver ?? User::factory(),
        ]);
    }

    public function rejected(?User $approver = null): self
    {
        return $this->state([
            'status' => SubmissionStatus::Rejected,
            'approved_at' => null,
            'approver_id' => $approver ?? User::factory(),
        ]);
    }
}
