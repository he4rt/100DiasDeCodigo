<?php

declare(strict_types=1);

namespace He4rt\Submission\Filament\Admin\Resources\Submission;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use He4rt\Submission\Enums\SubmissionStatus;
use He4rt\Submission\Filament\Admin\Resources\Submission\Actions\ReviewSubmissionAction;
use He4rt\Submission\Filament\Admin\Resources\Submission\Pages\CreateSubmission;
use He4rt\Submission\Filament\Admin\Resources\Submission\Pages\EditSubmission;
use He4rt\Submission\Filament\Admin\Resources\Submission\Pages\ListSubmissions;
use He4rt\Submission\Filament\Admin\Resources\Submission\Pages\MatchSubmissionsPage;
use He4rt\Submission\Models\Submission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubmissionResource extends Resource
{
    protected static ?string $model = Submission::class;

    protected static ?string $slug = 'submissions';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Fieldset::make('Submission Details')
                    ->columnSpan(1)
                    ->schema([
                        Fieldset::make('Base Details')
                            ->columnSpanFull()
                            ->schema([
                                Select::make('user_id')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->disabled()
                                    ->required(),
                                TextInput::make('tweet_id')
                                    ->readOnly()
                                    ->disabled()
                                    ->suffixAction(
                                        Action::make('Check Tweet')
                                            ->icon(Heroicon::ArrowUpRight)
                                            ->url(fn (string $state) => sprintf('https://x.com/i/status/%s', $state), true)
                                    )
                                    ->required(),
                            ]),

                        Select::make('approver_id')
                            ->relationship('approver', 'name')
                            ->searchable()
                            ->disabled()
                            ->required(),

                        Select::make('status')
                            ->disabled()
                            ->options(SubmissionStatus::class)
                            ->required(),

                        DateTimePicker::make('submitted_at')
                            ->label('Submitted Date'),

                        DatePicker::make('approved_at')
                            ->label('Approved Date'),

                        TextEntry::make('created_at')
                            ->label('Created Date')
                            ->state(fn (?Submission $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                        TextEntry::make('updated_at')
                            ->label('Last Modified Date')
                            ->state(fn (?Submission $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
                    ]),
                View::make('submission::components.submission-card')
                    ->columnSpan(1)
                    ->viewData(fn (?Submission $record): array => [
                        'submission' => $record,
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->default(fn (?Submission $record): string => $record->getTweet()->author->userName)
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

    public static function getPages(): array
    {
        return [
            'index' => ListSubmissions::route('/'),
            'create' => CreateSubmission::route('/create'),
            'edit' => EditSubmission::route('/{record}/edit'),
            'match' => MatchSubmissionsPage::route('/match'),
        ];
    }

    /**
     * @return Builder<Submission>
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    /**
     * @return Builder<Submission>
     */
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['approver', 'user']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['approver.name', 'user.name'];
    }

    /**
     * @param  Submission  $record
     */
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->approver) {
            $details['Approver'] = $record->approver->name;
        }

        if ($record->user) {
            $details['User'] = $record->user->name;
        }

        return $details;
    }
}
