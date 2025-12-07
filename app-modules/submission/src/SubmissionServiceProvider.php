<?php

declare(strict_types=1);

namespace He4rt\Submission;

use Filament\Panel;
use Illuminate\Support\ServiceProvider;

class SubmissionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Panel::configureUsing(fn (Panel $panel) => match ($panel->getId()) {
            'app' => $panel->plugin(new AppSubmissionPanelPlugin),
            'admin' => $panel->plugin(new AdminSubmissionPanelPlugin),
            default => null,
        });
    }

    public function boot(): void {}
}
