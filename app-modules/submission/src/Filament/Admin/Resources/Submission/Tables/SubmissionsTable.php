<?php

declare(strict_types=1);

namespace He4rt\Submission\Filament\Admin\Resources\Submission\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use He4rt\Submission\Filament\Admin\Resources\Submission\Actions\ReviewSubmissionAction;
use He4rt\Submission\Models\Submission;

final class SubmissionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->default(fn (?Submission $record): ?string => $record?->getTweet()?->author->userName)
                    ->sortable(),

                TextColumn::make('user.username')
                    ->copyable()
                    ->badge()
                    ->toggleable()
                    ->searchable(),

                TextColumn::make('status')
                    ->badge(),

                TextColumn::make('progress'),

                TextColumn::make('submitted_at')
                    ->label('Submitted Date')
                    ->date(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ReviewSubmissionAction::make(),
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ]);
    }
}
