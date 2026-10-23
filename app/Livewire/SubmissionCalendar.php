<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class SubmissionCalendar extends Component
{
    public User $user;

    public function mount(User $user): void
    {
        $this->user = $user;
    }

    public function render(): View
    {
        $submissions = $this->user->submissions()
            ->whereNotNull('submitted_at')
            ->oldest('submitted_at')
            ->get();

        $startDate = $submissions->first()?->submitted_at?->startOfDay() ?? today();

        return view('livewire.submission-calendar', [
            'submissions' => $submissions->groupBy(fn ($submission) => $submission->submitted_at->format('Y-m-d')),
            'startDate' => $startDate,
            'stats' => $this->user->getSubmissionStats(),
        ]);
    }
}
