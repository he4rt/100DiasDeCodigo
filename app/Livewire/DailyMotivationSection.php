<?php

declare(strict_types=1);

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

final class DailyMotivationSection extends Component
{
    public function render(): View
    {
        return view('livewire.daily-motivation-section', [
            'quote' => 'A consistência é mais importante que a perfeição. Continue codando, um dia de cada vez.',
        ]);
    }
}
