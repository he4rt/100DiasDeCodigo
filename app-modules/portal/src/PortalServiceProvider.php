<?php

declare(strict_types=1);

namespace He4rt\Portal;

use Filament\Panel;
use He4rt\Portal\Pages\ParticipantsPage;
use Illuminate\Support\ServiceProvider;

final class PortalServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Panel::configureUsing(function (Panel $panel): void {
            if ($panel->currentPanel()->isGuest()) {
                $panel->pages([
                    ParticipantsPage::class,
                ]);
            }
        });
    }
}
