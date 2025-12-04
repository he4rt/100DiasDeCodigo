<?php

declare(strict_types=1);

namespace He4rt\User\Filament\Pages;

use Filament\Notifications\Notification;
use Filament\Pages\Concerns\CanUseDatabaseTransactions;
use Filament\Pages\Dashboard;
use Filament\Schemas\Schema;
use He4rt\Submission\Enums\SubmissionStatus;
use He4rt\Submission\Filament\App\Resources\Submissions\Schemas\SubmissionForm;
use He4rt\Submission\Models\Submission;
use Throwable;

/**
 * @property Schema $submissionForm
 */
class UserDashboard extends Dashboard
{
    use CanUseDatabaseTransactions;

    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    protected string $view = 'user::filament.dashboard';

    public function mount(): void
    {
        $this->submissionForm->fill([]);
    }

    public function submissionForm(Schema $schema): Schema
    {
        return SubmissionForm::configure($schema)
            ->statePath('data');
    }

    public function submitSubmission(): void
    {
        try {
            $exists = Submission::query()
                ->where('user_id', auth()->id())
                ->whereDate('submitted_at', today())
                ->exists();

            //            if ($exists) {
            //                $this->halt();
            //            }
        } catch (Throwable) {
            Notification::make()
                ->danger()
                ->title('You have already submitted your daily progress for this date.')
                ->send();
        }

        $field = $this->data['field'] ?? [];
        $technologies = $this->data['technologies'] ?? [];
        unset($this->data['field'], $this->data['technologies']);

        $submission = Submission::query()->create([
            ...$this->data,
            'user_id' => auth()->id(),
            'submitted_at' => now(),
            'status' => SubmissionStatus::Pending,
        ]);

        $submission->attachTags($field, 'field');
        $submission->attachTags($technologies, 'technologies');

        Notification::make()
            ->success()
            ->title('Your submission was successfully registered.')
            ->send();

        auth()->user()->invalidateSubmissionStatsCache();
    }
}
