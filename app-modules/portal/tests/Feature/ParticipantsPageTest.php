<?php

declare(strict_types=1);

use App\Models\User;
use Filament\Facades\Filament;
use He4rt\Portal\Pages\ParticipantsPage;
use He4rt\Submission\Models\Submission;

use function Pest\Livewire\livewire;

beforeEach(function (): void {
    Filament::setCurrentPanel('guest');
});

it('renders when no participant has an active streak', function (): void {
    Submission::factory()
        ->count(2)
        ->sequence(fn () => ['user_id' => User::factory()])
        ->create(['submitted_at' => now()->subDays(10)]);

    livewire(ParticipantsPage::class)
        ->assertOk()
        ->assertSee('Média de Streak');
});

it('renders without participants', function (): void {
    livewire(ParticipantsPage::class)
        ->assertOk();
});
