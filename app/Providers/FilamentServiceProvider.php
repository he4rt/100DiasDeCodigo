<?php

declare(strict_types=1);

namespace App\Providers;

use App\Enums\FilamentPanel;
use App\Filament\Shared\Responses\LogoutResponse as LogoutResponseImpl;
use Filament\Auth\Http\Responses\Contracts\LogoutResponse as LogoutResponseContract;
use Filament\Panel;
use Illuminate\Support\ServiceProvider;

final class FilamentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(LogoutResponseContract::class, LogoutResponseImpl::class);

        $this->configureMacros();
    }

    private function configureMacros(): void
    {
        Panel::macro('currentPanel', function (): FilamentPanel {
            /** @var string $panelId */
            $panelId = $this->getId();

            return FilamentPanel::from($panelId);
        });
    }
}
