<?php

declare(strict_types=1);

namespace He4rt\Submission\Filament\App\Resources\Submissions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use He4rt\Submission\Enums\SubmissionStatus;
use He4rt\Submission\Models\Submission;

class SubmissionsTable
{
    public static function configure(Table $table): Table
    {
        $format = 'd/m/Y H:i';

        return $table
            ->columns([
                TextColumn::make('content')
                    ->limit(50)
                    ->tooltip(fn (TextColumn $column): ?string => $column->getState())
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('submitted_at')
                    ->dateTime($format)
                    ->sortable(),
                TextColumn::make('approver.name')
                    ->label('Reviewed By')
                    ->placeholder('Pending')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('approved_at')
                    ->dateTime($format)
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime($format)
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('tweet_url')
                    ->state(fn (Submission $record) => filled($record->tweet_id))
                    ->alignCenter()
                    ->verticallyAlignCenter()
                    ->label('Ver tweet')
                    ->icon(Heroicon::ArrowUpRight)
                    ->url(fn (Submission $record) => $record->tweet_id ? sprintf('https://x.com/i/status/%s', $record->tweet_id) : null)
                    ->openUrlInNewTab(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(SubmissionStatus::class),
                TrashedFilter::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
