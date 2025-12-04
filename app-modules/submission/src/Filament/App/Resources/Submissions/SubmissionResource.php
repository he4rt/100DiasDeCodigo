<?php

declare(strict_types=1);

namespace He4rt\Submission\Filament\App\Resources\Submissions;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use He4rt\Submission\Filament\App\Resources\Submissions\Pages\CreateSubmission;
use He4rt\Submission\Filament\App\Resources\Submissions\Pages\EditSubmission;
use He4rt\Submission\Filament\App\Resources\Submissions\Pages\ListSubmissions;
use He4rt\Submission\Filament\App\Resources\Submissions\Schemas\SubmissionForm;
use He4rt\Submission\Filament\App\Resources\Submissions\Tables\SubmissionsTable;
use He4rt\Submission\Models\Submission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubmissionResource extends Resource
{
    protected static ?string $model = Submission::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return SubmissionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SubmissionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSubmissions::route('/'),
            'create' => CreateSubmission::route('/create'),
            'edit' => EditSubmission::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
