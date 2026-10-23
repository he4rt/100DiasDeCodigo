<?php

declare(strict_types=1);

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

final class CommunityHighlightSection extends Component
{
    public function render(): View
    {
        return view('livewire.community-highlight-section', [
            'highlights' => [
                [
                    'name' => 'Sarah Chen',
                    'username' => 'sarahcodes',
                    'day' => 78,
                    'badge' => 'Frontend',
                    'badge_color' => 'bg-blue-500/10 text-blue-500',
                    'avatar' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/attachments/gen-images/public/asian-woman-developer-5nOZgVvcU9vrYSuOOuas6hVf1tH5HY.png',
                ],
                [
                    'name' => 'Erik Müller',
                    'username' => 'erikdev',
                    'day' => 100,
                    'badge' => 'Finalista',
                    'badge_color' => 'bg-yellow-500/10 text-yellow-500',
                    'avatar' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/attachments/gen-images/public/german-man-developer-jYIOHQ8mTk331ZDHB04ubKPDtoIrCK.jpg',
                ],
                [
                    'name' => 'Priya Sharma',
                    'username' => 'priyaml',
                    'day' => 56,
                    'badge' => 'ML',
                    'badge_color' => 'bg-purple-500/10 text-purple-500',
                    'avatar' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/attachments/gen-images/public/indian-woman-developer-i6ehu928Ef9gyolqMDi0BNngPYTPoQ.png',
                ],
            ],
        ]);
    }
}
