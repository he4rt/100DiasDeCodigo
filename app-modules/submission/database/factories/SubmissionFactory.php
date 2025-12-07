<?php

declare(strict_types=1);

namespace He4rt\Submission\Database\Factories;

use App\Models\User;
use He4rt\Submission\Models\Submission;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

/** @extends Factory<Submission> */
class SubmissionFactory extends Factory
{
    protected $model = Submission::class;

    public function definition(): array
    {
        return [
            'submitted_at' => Date::now(),
            'tweet_id' => fake()->randomNumber(7),
            'metadata' => [],
            'status' => fake()->word(),
            'content' => fake()->sentence(),
            'approved_at' => Date::now(),
            'created_at' => Date::now(),
            'updated_at' => Date::now(),

            'user_id' => User::factory(),
            'approver_id' => User::factory(),
        ];
    }
}
