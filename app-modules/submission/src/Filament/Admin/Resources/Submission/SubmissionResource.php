<?php

declare(strict_types=1);

namespace He4rt\Submission\Filament\Admin\Resources\Submission;

use BackedEnum;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use He4rt\Submission\Filament\Admin\Resources\Submission\Pages\CreateSubmission;
use He4rt\Submission\Filament\Admin\Resources\Submission\Pages\EditSubmission;
use He4rt\Submission\Filament\Admin\Resources\Submission\Pages\ListSubmissions;
use He4rt\Submission\Filament\Admin\Resources\Submission\Pages\MatchSubmissionsPage;
use He4rt\Submission\Filament\Admin\Resources\Submission\Schemas\SubmissionForm;
use He4rt\Submission\Filament\Admin\Resources\Submission\Tables\SubmissionsTable;
use He4rt\Submission\Models\Submission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

final class SubmissionResource extends Resource
{
    /** @var class-string<Submission>|null */
    protected static ?string $model = Submission::class;

    protected static ?string $slug = 'submissions';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return SubmissionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SubmissionsTable::configure($table);
    }

    /**
     * @return array<string, PageRegistration>
     */
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
        /** @var Builder<Submission> */
        return parent::getEloquentQuery()->withoutGlobalScopes([SoftDeletingScope::class]);
    }

    /**
     * @return Builder<Submission>
     */
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        /** @var Builder<Submission> */
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
