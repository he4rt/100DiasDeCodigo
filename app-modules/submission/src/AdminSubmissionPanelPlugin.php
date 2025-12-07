<?php

declare(strict_types=1);

namespace He4rt\Submission;

use Filament\Contracts\Plugin;
use Filament\Panel;

class AdminSubmissionPanelPlugin implements Plugin
{
    public function getId(): string
    {
        return 'admin-submission-plugin';
    }

    public function register(Panel $panel): void
    {
        $panel->discoverResources(
            in: __DIR__.'/Filament/Admin/Resources',
            for: 'He4rt\\Submission\\Filament\\Admin\\Resources'
        );
    }

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }
}
