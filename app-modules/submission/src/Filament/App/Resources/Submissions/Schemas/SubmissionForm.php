<?php

declare(strict_types=1);

namespace He4rt\Submission\Filament\App\Resources\Submissions\Schemas;

use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

final class SubmissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make('O que você aprendeu hoje?')
                    ->columns(3)
                    ->schema([
                        Grid::make(2)
                            ->columnSpanFull()
                            ->schema([
                                SpatieTagsInput::make('field')
                                    ->type('field_type'),
                                SpatieTagsInput::make('technologies')

                                    ->type('technologies'),
                            ]),
                        MarkdownEditor::make('content')->columnSpanFull(),
                    ]),
            ]);
    }
}
