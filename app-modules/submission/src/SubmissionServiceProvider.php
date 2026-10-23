<?php

declare(strict_types=1);

namespace He4rt\Submission;

use Filament\Panel;
use Illuminate\Support\ServiceProvider;

final class SubmissionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Panel::configureUsing(fn (Panel $panel) => match (true) {
            $panel->currentPanel()->isApp() => $panel->plugin(new AppSubmissionPanelPlugin),
            $panel->currentPanel()->isAdmin() => $panel->plugin(new AdminSubmissionPanelPlugin),
            default => null,
        });
    }
}
