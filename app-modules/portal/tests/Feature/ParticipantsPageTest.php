<?php

declare(strict_types=1);

use App\Models\User;
use Filament\Facades\Filament;
use He4rt\Portal\Pages\ParticipantsPage;
use He4rt\Submission\Models\Submission;
use Illuminate\Support\Facades\DB;

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

it('keeps the query count flat as participants grow', function (): void {
    $queriesFor = function (int $participants): int {
        Submission::factory()
            ->count($participants)
            ->sequence(fn () => ['user_id' => User::factory()])
            ->create();

        cache()->flush();
        DB::flushQueryLog();
        DB::enableQueryLog();

        livewire(ParticipantsPage::class)->assertOk();

        return count(DB::getQueryLog());
    };

    expect($queriesFor(5))->toBe($queriesFor(5));
});
