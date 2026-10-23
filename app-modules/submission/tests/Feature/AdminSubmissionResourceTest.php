<?php

declare(strict_types=1);

use App\Enums\FilamentPanel;
use App\Models\User;
use Filament\Facades\Filament;
use He4rt\Submission\Enums\SubmissionStatus;
use He4rt\Submission\Filament\Admin\Resources\Submission\Actions\ReviewSubmissionAction;
use He4rt\Submission\Filament\Admin\Resources\Submission\Pages\EditSubmission;
use He4rt\Submission\Filament\Admin\Resources\Submission\Pages\ListSubmissions;
use He4rt\Submission\Models\Submission;

use function Pest\Livewire\livewire;

beforeEach(function (): void {
    config()->set('he4rt.admins', ['admin']);
    Filament::setCurrentPanel(FilamentPanel::Admin->value);

    $this->admin = User::factory()->create(['username' => 'admin']);
    $this->actingAs($this->admin);
});

it('lists submissions', function (): void {
    $submissions = Submission::factory()->count(2)->create();

    livewire(ListSubmissions::class)
        ->assertOk()
        ->assertCanSeeTableRecords($submissions);
});

it('approves a pending submission', function (): void {
    $submission = Submission::factory()->pending()->create();

    livewire(ListSubmissions::class)
        ->callTableAction(ReviewSubmissionAction::class, $submission, data: [
            'status' => SubmissionStatus::Approved->value,
        ])
        ->assertHasNoTableActionErrors();

    $submission->refresh();

    expect($submission->status)->toBe(SubmissionStatus::Approved)
        ->and($submission->approver_id)->toBe($this->admin->id)
        ->and($submission->approved_at)->not->toBeNull();
});

it('disables the review of a submission that is not pending', function (): void {
    $submission = Submission::factory()->approved()->create();

    livewire(ListSubmissions::class)
        ->assertTableActionDisabled(ReviewSubmissionAction::class, $submission);
});

it('renders the edit page', function (): void {
    $submission = Submission::factory()->create();

    livewire(EditSubmission::class, ['record' => $submission->getRouteKey()])
        ->assertOk();
});
