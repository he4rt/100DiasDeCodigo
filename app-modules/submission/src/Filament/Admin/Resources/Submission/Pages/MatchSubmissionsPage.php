<?php

declare(strict_types=1);

namespace He4rt\Submission\Filament\Admin\Resources\Submission\Pages;

use Filament\Resources\Pages\Page;
use He4rt\Submission\Enums\SubmissionStatus;
use He4rt\Submission\Filament\Admin\Resources\Submission\SubmissionResource;
use He4rt\Submission\Models\Submission;

class MatchSubmissionsPage extends Page
{
    public static ?string $title = '';

    public ?Submission $submission = null;

    public int $submissionsCount = 0;

    protected static string $resource = SubmissionResource::class;

    protected string $view = 'submission::filament.admin.resources.submission.submission-resource.pages.match-submissions-page';

    public function getBreadcrumbs(): array
    {
        return [];
    }

    public function mount(): void
    {
        $this->submission = Submission::query()->where('status', SubmissionStatus::Pending)->first();
        $this->submissionsCount = Submission::query()->where('status', SubmissionStatus::Pending)->count();
    }

    public function matchSubmission(SubmissionStatus $status): void
    {
        $this->submission->update(['status' => $status]);
        $this->submission = Submission::query()->where('status', SubmissionStatus::Pending)->first();
    }
}
