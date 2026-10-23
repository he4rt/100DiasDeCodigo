<?php

declare(strict_types=1);

namespace He4rt\User\Filament\Admin\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use He4rt\User\Filament\Admin\Resources\Users\Actions\RefreshSubmissionsAction;
use Illuminate\Database\Eloquent\Builder;

final class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->withExists([
                'accounts as has_twitter' => fn (Builder $query): Builder => $query->where('provider', 'twitter'),
            ]))
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('username')
                    ->copyable()
                    ->copyMessage('Username copied to clipboard!')
                    ->badge()
                    ->searchable(),
                IconColumn::make('has_twitter')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([

            ])
            ->recordActions([
                RefreshSubmissionsAction::make(),
                EditAction::make()
                    ->label('')
                    ->tooltip('Edit User'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
