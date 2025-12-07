<?php

declare(strict_types=1);

namespace He4rt\Submission\Filament\Admin\Resources\Submission\Pages;

use Filament\Resources\Pages\CreateRecord;
use He4rt\Submission\Filament\Admin\Resources\Submission\SubmissionResource;

class CreateSubmission extends CreateRecord
{
    protected static string $resource = SubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
