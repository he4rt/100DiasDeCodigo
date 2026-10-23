<?php

declare(strict_types=1);

use App\Models\User;
use He4rt\Submission\Models\Submission;
use Illuminate\Support\Facades\Date;

beforeEach(function (): void {
    $this->travelTo(Date::parse('2026-10-20 12:00:00'));
});

/**
 * @param  list<string>  $dates
 */
function userWithSubmissionsOn(array $dates): User
{
    $user = User::factory()->create();

    foreach ($dates as $date) {
        Submission::factory()->for($user)->create(['submitted_at' => Date::parse($date)]);
    }

    return $user;
}

/** @var array<string, Closure(User): User> */
$sources = [
    'queried' => fn (User $user): User => $user,
    'eager loaded' => fn (User $user): User => $user->load('submissions'),
];

it('computes the streaks, days and submissions', function (Closure $source): void {
    $user = userWithSubmissionsOn([
        '2026-10-20 09:00:00',
        '2026-10-20 18:00:00',
        '2026-10-18 10:00:00',
        '2026-10-10 10:00:00',
        '2026-10-09 10:00:00',
        '2026-10-08 10:00:00',
    ]);

    expect($source($user)->getSubmissionStats())->toBe([
        'current_streak' => 2,
        'longest_streak' => 3,
        'total_days' => 5,
        'total_submissions' => 6,
    ]);
})->with($sources);

it('resets the current streak after more than 5 days without a submission', function (Closure $source): void {
    $user = userWithSubmissionsOn(['2026-10-14 10:00:00', '2026-10-13 10:00:00']);

    expect($source($user)->getSubmissionStats())->toMatchArray([
        'current_streak' => 0,
        'longest_streak' => 2,
    ]);
})->with($sources);

it('ignores deleted submissions', function (Closure $source): void {
    $user = userWithSubmissionsOn(['2026-10-20 10:00:00', '2026-10-19 10:00:00']);
    $user->submissions()->latest('submitted_at')->first()?->delete();

    expect($source($user)->getSubmissionStats())->toMatchArray([
        'total_days' => 1,
        'total_submissions' => 1,
    ]);
})->with($sources);

it('returns zero stats without submissions', function (Closure $source): void {
    expect($source(User::factory()->create())->getSubmissionStats())->toBe([
        'current_streak' => 0,
        'longest_streak' => 0,
        'total_days' => 0,
        'total_submissions' => 0,
    ]);
})->with($sources);
