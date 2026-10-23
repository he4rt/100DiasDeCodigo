<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use App\Filament\Shared\Actions\GoToAdminAction;
use App\Filament\Shared\Actions\GoToAppAction;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use He4rt\Portal\Pages\PortalPage;
use He4rt\Portal\Pages\PublicUserProfilePage;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Vite;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class GuestPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('guest')
            ->default()
            ->path('')
            ->colors([
                'primary' => Color::Purple,
            ])
            ->topNavigation()
            ->renderHook(PanelsRenderHook::TOPBAR_END, fn () => Blade::render(<<<'HTML'
                    @guest
                        <x-he4rt::button href="/app" icon-position="leading" icon="heroicon-o-user">Acessar Plataforma</x-he4rt::button>
                    @endguest
                HTML
            ))
            ->pages([
                PortalPage::class,
                PublicUserProfilePage::class,
            ])
            ->userMenuItems([
                GoToAppAction::make(),
                GoToAdminAction::make(),
            ])
            ->viteTheme('app-modules/he4rt/resources/css/theme.css')
            ->renderHook(PanelsRenderHook::HEAD_END, fn () => Vite::fonts(['satoshi', 'fira-code']))
            ->discoverWidgets(in: app_path('Filament/Guest/Widgets'), for: 'App\Filament\Guest\Widgets')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ]);
    }
}
