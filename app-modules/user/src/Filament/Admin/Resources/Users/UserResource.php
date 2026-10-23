<?php

declare(strict_types=1);

namespace He4rt\User\Filament\Admin\Resources\Users;

use App\Models\User;
use BackedEnum;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use He4rt\User\Filament\Admin\Resources\Users\Pages\CreateUser;
use He4rt\User\Filament\Admin\Resources\Users\Pages\EditUser;
use He4rt\User\Filament\Admin\Resources\Users\Pages\ListUsers;
use He4rt\User\Filament\Admin\Resources\Users\Schemas\UserForm;
use He4rt\User\Filament\Admin\Resources\Users\Tables\UsersTable;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'username';

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [

        ];
    }

    /**
     * @return array<string, PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
