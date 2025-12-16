<?php

declare(strict_types=1);

namespace He4rt\User\Filament\Admin\Resources\Users\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use He4rt\User\Filament\Admin\Resources\Users\Actions\BulkRefreshSubmissionsAction;
use He4rt\User\Filament\Admin\Resources\Users\UserResource;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected ?string $heading = '';

    protected function getHeaderActions(): array
    {
        return [
            BulkRefreshSubmissionsAction::make(),
            CreateAction::make(),
        ];
    }
}
