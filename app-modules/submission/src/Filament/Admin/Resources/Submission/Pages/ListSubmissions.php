<?php

declare(strict_types=1);

namespace He4rt\Submission\Filament\Admin\Resources\Submission\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use He4rt\Submission\Enums\SubmissionStatus;
use He4rt\Submission\Filament\Admin\Resources\Submission\SubmissionResource;
use He4rt\Submission\Models\Submission;
use Illuminate\Database\Eloquent\Builder;

class ListSubmissions extends ListRecords
{
    protected static string $resource = SubmissionResource::class;

    protected ?string $heading = '';

    public function getTabs(): array
    {
        $tabs = collect(SubmissionStatus::cases())
            ->mapWithKeys(fn (SubmissionStatus $status) => [
                $status->value => Tab::make()
                    ->badge(Submission::query()->where('status', $status)->count())
                    ->badgeColor($status->getColor())
                    ->icon($status->getIcon())
                    ->modifyQueryUsing(fn (Builder $query) => $query->where('status', $status)),
            ]);

        return [
            'all' => Tab::make()->badge(Submission::query()->count()),
            ...$tabs->toArray(),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('match')
                ->url(MatchSubmissionsPage::getUrl())
                ->outlined()
                ->label('Match'),
            CreateAction::make(),
        ];
    }
}
