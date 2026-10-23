<?php

declare(strict_types=1);

namespace He4rt\Submission\Filament\Admin\Resources\Submission\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use He4rt\Submission\Enums\SubmissionStatus;
use He4rt\Submission\Models\Submission;

final class SubmissionForm
{
    public static function configure(Schema $schema): Schema
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
                                    ->disabled()
                                    ->required(),
                                TextInput::make('tweet_id')
                                    ->readOnly()
                                    ->disabled()
                                    ->suffixAction(
                                        Action::make('Check Tweet')
                                            ->icon(Heroicon::ArrowUpRight)
                                            ->url(fn (string $state) => sprintf('https://x.com/i/status/%s', $state), shouldOpenInNewTab: true)
                                    )
                                    ->required(),
                            ]),

                        Select::make('approver_id')
                            ->relationship('approver', 'name')
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
}
