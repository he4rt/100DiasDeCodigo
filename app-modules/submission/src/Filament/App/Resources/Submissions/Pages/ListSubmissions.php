<?php

declare(strict_types=1);

namespace He4rt\Submission\Filament\App\Resources\Submissions\Pages;

use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use He4rt\Submission\Enums\SubmissionStatus;
use He4rt\Submission\Filament\App\Resources\Submissions\SubmissionResource;
use He4rt\Submission\Models\Submission;
use Illuminate\Database\Eloquent\Builder;

class ListSubmissions extends ListRecords
{
    protected static string $resource = SubmissionResource::class;

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All'),
            'pending' => Tab::make('Pending')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', SubmissionStatus::Pending)),
            'approved' => Tab::make('Approved')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', SubmissionStatus::Approved)),
            'rejected' => Tab::make('Rejected')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', SubmissionStatus::Rejected)),
        ];
    }

    /**
     * @return Builder<Submission>|null
     */
    protected function getTableQuery(): ?Builder
    {
        return parent::getTableQuery()
            ->where('user_id', auth()->id())
            ->latest('submitted_at');
    }
}
