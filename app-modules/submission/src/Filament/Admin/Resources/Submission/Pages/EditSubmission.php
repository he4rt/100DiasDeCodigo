<?php

declare(strict_types=1);

namespace He4rt\Submission\Filament\Admin\Resources\Submission\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use He4rt\Submission\Filament\Admin\Resources\Submission\Actions\ReviewSubmissionAction;
use He4rt\Submission\Filament\Admin\Resources\Submission\SubmissionResource;

class EditSubmission extends EditRecord
{
    protected static string $resource = SubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ReviewSubmissionAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
