<?php

declare(strict_types=1);

namespace App\Providers;

use App\Enums\FilamentPanel;
use App\Filament\Shared\Responses\LogoutResponse as LogoutResponseImpl;
use Filament\Auth\Http\Responses\Contracts\LogoutResponse as LogoutResponseContract;
use Filament\Facades\Filament;
use Filament\Panel;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;
use Illuminate\Support\ServiceProvider;

final class FilamentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(LogoutResponseContract::class, LogoutResponseImpl::class);

        $this->configureMacros();
    }

    public function boot(): void
    {
        $this->configureNoIndex();
    }

    private function configureMacros(): void
    {
        Panel::macro('currentPanel', function (): FilamentPanel {
            /** @var string $panelId */
            $panelId = $this->getId();

            return FilamentPanel::from($panelId);
        });
    }

    private function configureNoIndex(): void
    {
        FilamentView::registerRenderHook(
            PanelsRenderHook::HEAD_START,
            function (): HtmlString {
                $panel = Filament::getCurrentPanel();

                if ($panel === null || $panel->currentPanel()->isGuest()) {
                    return new HtmlString('');
                }

                return new HtmlString('<meta name="robots" content="noindex, nofollow" />');
            },
        );
    }
}
