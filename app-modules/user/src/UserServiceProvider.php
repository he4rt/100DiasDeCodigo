<?php

declare(strict_types=1);

namespace He4rt\User;

use Filament\Panel;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Panel::configureUsing(function (Panel $panel): void {
            if ($panel->getId() === 'admin') {
                $panel->discoverResources(
                    in: __DIR__.'/Filament/Admin/Resources',
                    for: 'He4rt\\User\\Filament\\Admin\\Resources'
                );
            }
        });
    }

    public function boot(): void {}
}
