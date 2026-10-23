<?php

declare(strict_types=1);

namespace He4rt\Submission\Filament\App\Resources\Submissions\Pages;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use He4rt\Submission\Filament\App\Resources\Submissions\SubmissionResource;

final class EditSubmission extends EditRecord
{
    protected static string $resource = SubmissionResource::class;

    /**
     * @return Action[]
     */
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
