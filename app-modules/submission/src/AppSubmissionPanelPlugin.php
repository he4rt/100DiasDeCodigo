<?php

declare(strict_types=1);

namespace He4rt\Submission;

use Filament\Contracts\Plugin;
use Filament\Panel;

final class AppSubmissionPanelPlugin implements Plugin
{
    public function getId(): string
    {
        return 'user-submission-plugin';
    }

    public function register(Panel $panel): void
    {
        $panel->discoverResources(
            in: __DIR__.'/Filament/App/Resources',
            for: 'He4rt\\Submission\\Filament\\App\\Resources'
        );
    }

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }
}
