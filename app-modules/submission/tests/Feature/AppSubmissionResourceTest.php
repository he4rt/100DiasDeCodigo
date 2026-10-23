<?php

declare(strict_types=1);

use App\Enums\FilamentPanel;
use App\Models\User;
use Filament\Facades\Filament;
use He4rt\Submission\Enums\SubmissionStatus;
use He4rt\Submission\Filament\App\Resources\Submissions\Pages\CreateSubmission;
use He4rt\Submission\Filament\App\Resources\Submissions\Pages\ListSubmissions;
use He4rt\Submission\Models\Submission;

use function Pest\Livewire\livewire;

beforeEach(function (): void {
    Filament::setCurrentPanel(FilamentPanel::App->value);
});

it('creates a pending submission for the authenticated user', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    livewire(CreateSubmission::class)
        ->fillForm(['content' => 'Dia 1 / 100'])
        ->call('create')
        ->assertHasNoFormErrors();

    expect(Submission::query()->sole())
        ->user_id->toBe($user->id)
        ->status->toBe(SubmissionStatus::Pending);
});

it('blocks a second submission on the same day', function (): void {
    $user = User::factory()->create();
    Submission::factory()->for($user)->create(['submitted_at' => now()]);
    $this->actingAs($user);

    livewire(CreateSubmission::class)
        ->fillForm(['content' => 'Dia 2 / 100'])
        ->call('create');

    expect(Submission::query()->count())->toBe(1);
});

it('lists only the submissions of the authenticated user', function (): void {
    $user = User::factory()->create();
    $ownSubmission = Submission::factory()->for($user)->create();
    $otherSubmission = Submission::factory()->create();

    $this->actingAs($user);

    livewire(ListSubmissions::class)
        ->loadTable()
        ->assertCanSeeTableRecords([$ownSubmission])
        ->assertCanNotSeeTableRecords([$otherSubmission]);
});
