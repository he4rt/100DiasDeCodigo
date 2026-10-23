<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class NextMilestoneSection extends Component
{
    public User $user;

    public function mount(User $user): void
    {
        $this->user = $user;
    }

    public function render(): View
    {
        $currentDay = $this->user->total_days ?? 0;
        $milestones = [1, 25, 50, 75, 100];
        $nextMilestone = 100;

        foreach ($milestones as $milestone) {
            if ($currentDay < $milestone) {
                $nextMilestone = $milestone;
                break;
            }
        }

        $daysRemaining = $nextMilestone - $currentDay;

        return view('livewire.next-milestone-section', [
            'currentDay' => $currentDay,
            'nextMilestone' => $nextMilestone,
            'daysRemaining' => $daysRemaining,
        ]);
    }
}
