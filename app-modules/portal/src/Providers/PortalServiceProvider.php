<?php

declare(strict_types=1);

namespace He4rt\Portal\Providers;

use Filament\Panel;
use He4rt\Portal\Pages\ParticipantsPage;
use Illuminate\Support\ServiceProvider;

class PortalServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Panel::configureUsing(fn (Panel $panel) => match ($panel->getId()) {
            'guest' => $panel->pages([
                ParticipantsPage::class,
            ]),
            default => null,
        });
    }

    public function boot(): void {}
}
