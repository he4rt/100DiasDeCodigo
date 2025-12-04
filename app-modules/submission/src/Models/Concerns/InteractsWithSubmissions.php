<?php

declare(strict_types=1);

namespace He4rt\Submission\Models\Concerns;

use Carbon\Month;
use Carbon\WeekDay;
use DateTimeInterface;
use He4rt\Submission\Models\Submission;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;

trait InteractsWithSubmissions
{
    /**
     * @return HasMany<Submission, $this>
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }

    /**
     * @return HasOne<Submission, $this>
     */
    public function dailySubmission(): HasOne
    {
        return $this->hasOne(Submission::class)
            ->whereNotNull('submitted_at')
            ->whereDate('submitted_at', Date::today());
    }

    /**
     * @return array{current_streak: int, longest_streak: int, total_days: int, total_submissions: int}
     */
    public function getSubmissionStats(): array
    {
        return Cache::remember($this->getSubmissionStatsCacheKey(), 3600, fn () => $this->calculateSubmissionStats());
    }

    public function getSubmissionStatsCacheKey(): string
    {
        return 'submission_stats:'.$this->getKey();
    }

    public function invalidateSubmissionStatsCache(): void
    {
        Cache::forget($this->getSubmissionStatsCacheKey());
    }

    /**
     * @return array{current_streak: int, longest_streak: int, total_days: int, total_submissions: int}
     */
    protected function calculateSubmissionStats(): array
    {
        // Get all submission dates, distinct, ordered by date desc
        $dates = $this->submissions()
            ->selectRaw('DATE(submitted_at) as date')
            ->whereNotNull('submitted_at')
            ->distinct()
            ->orderBy('date', 'desc')
            ->pluck('date')
            ->map(fn (DateTimeInterface|WeekDay|Month|string|int|float|null $date) => Date::parse($date)->startOfDay());

        if ($dates->isEmpty()) {
            return [
                'current_streak' => 0,
                'longest_streak' => 0,
                'total_days' => 0,
                'total_submissions' => 0,
            ];
        }

        $totalDays = $dates->count();
        $totalSubmissions = $this->submissions()->count();
        $longestStreak = 0;
        $currentStreak = 0;

        // Calculate Streaks
        $streak = 0;
        $prevDate = null;

        // Iterate from newest to oldest
        foreach ($dates as $date) {
            if ($prevDate === null) {
                $streak = 1;
            } else {
                // Calculate gap in days
                // Example: Jan 6 (prev) - Jan 1 (date) = 5 days.
                // If gap > 5, streak breaks.
                // The requirement: "invalidated if the user don't post for 5 days in a row"
                // This implies a gap of 6 days or more breaks it. (5 full days of silence).
                // So diffInDays <= 5 is valid.

                $gap = $prevDate->diffInDays($date);

                if ($gap <= 5) {
                    $streak++;
                } else {
                    // Streak broken
                    if ($streak > $longestStreak) {
                        $longestStreak = $streak;
                    }

                    $streak = 1;
                }
            }

            $prevDate = $date;
        }

        // Check the last calculated streak
        if ($streak > $longestStreak) {
            $longestStreak = $streak;
        }

        // Calculate Current Streak
        // Current streak is valid only if the most recent submission is within the allowed gap from TODAY.
        $today = Date::now()->startOfDay();
        $mostRecent = $dates->first();

        // If the user hasn't posted for 5 days from today, current streak is 0.
        if ($today->diffInDays($mostRecent) > 5) {
            $currentStreak = 0;
        } else {
            // The first streak group we calculated above corresponds to the most recent submissions.
            // We can re-calculate it or just extract it.
            // Let's re-calculate to be safe and clear.
            $currentStreak = 1;
            $prev = $dates->first();

            foreach ($dates->slice(1) as $date) {
                if ($prev->diffInDays($date) <= 5) {
                    $currentStreak++;
                    $prev = $date;
                } else {
                    break;
                }
            }
        }

        return [
            'current_streak' => $currentStreak,
            'longest_streak' => $longestStreak,
            'total_days' => $totalDays,
            'total_submissions' => $totalSubmissions,
        ];
    }

    protected function getCurrentStreakAttribute(): int
    {
        return $this->getSubmissionStats()['current_streak'];
    }

    protected function getLongestStreakAttribute(): int
    {
        return $this->getSubmissionStats()['longest_streak'];
    }

    protected function getTotalDaysAttribute(): int
    {
        return $this->getSubmissionStats()['total_days'];
    }

    protected function getTotalSubmissionsAttribute(): int
    {
        return $this->getSubmissionStats()['total_submissions'];
    }
}
