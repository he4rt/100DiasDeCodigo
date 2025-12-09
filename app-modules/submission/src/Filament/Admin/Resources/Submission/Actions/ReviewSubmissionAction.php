<?php

declare(strict_types=1);

namespace He4rt\Submission\Filament\Admin\Resources\Submission\Actions;

use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use He4rt\Submission\Enums\SubmissionStatus;

class ReviewSubmissionAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Review Submission')
            ->icon(Heroicon::CheckCircle)
            ->color('primary')
            ->disabled(fn ($record): bool => $record->status !== SubmissionStatus::Pending)
            ->modal()
            ->modalHeading('Review Submission')
            ->modalDescription('Choose a status for this submission:')
            ->schema([
                Select::make('status')
                    ->label('Status')
                    ->options(SubmissionStatus::class)
                    ->required(),
            ])
            ->action(function (array $data, $record): void {
                $status = $data['status'];
                $updateData = [
                    'status' => $status,
                    'approver_id' => auth()->id(),
                ];

                if ($status === SubmissionStatus::Approved) {
                    $updateData['approved_at'] = now();
                }

                $record->update($updateData);

                Notification::make()
                    ->success()
                    ->title('Submission Reviewed!')
                    ->body(sprintf('Your submission has been reviewed as %s successfully.', $status->getLabel()))
                    ->send();
            });

    }

    public static function getDefaultName(): ?string
    {
        return 'review-submission-action';
    }
}
