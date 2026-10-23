<?php

declare(strict_types=1);

namespace He4rt\Submission\Filament\App\Resources\Submissions\Pages;

use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use He4rt\Submission\Enums\SubmissionStatus;
use He4rt\Submission\Filament\App\Resources\Submissions\SubmissionResource;
use He4rt\Submission\Models\Submission;

final class CreateSubmission extends CreateRecord
{
    protected static string $resource = SubmissionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $alreadySubmittedToday = Submission::query()
            ->where('user_id', auth()->id())
            ->whereDate('submitted_at', today())
            ->exists();

        if ($alreadySubmittedToday) {
            Notification::make()
                ->danger()
                ->title('You have already submitted your daily progress for this date.')
                ->send();

            $this->halt();
        }

        $data['user_id'] = auth()->id();
        $data['submitted_at'] = now();
        $data['status'] = SubmissionStatus::Pending;

        return $data;
    }
}
