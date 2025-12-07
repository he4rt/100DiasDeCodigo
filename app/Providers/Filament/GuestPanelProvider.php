<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use He4rt\Portal\Pages\PortalPage;
use He4rt\Portal\Pages\PublicUserProfilePage;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class GuestPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('guest')
            ->path('')
            ->colors([
                'primary' => Color::Purple,
            ])
            ->topNavigation(true)
            ->navigationItems([
                NavigationItem::make('Portal')
                    ->url('/')
                    ->icon('heroicon-o-home'),
            ])
            ->renderHook(PanelsRenderHook::TOPBAR_END, fn () => Blade::render(<<<'BLADE'
                @guest
                    <x-he4rt::button href="/app" icon-position="leading" icon="heroicon-o-user">Acessar Plataforma</x-he4rt::button>
                @endguest
            BLADE
            ))
            ->pages([
                PortalPage::class,
                PublicUserProfilePage::class,
            ])
            ->viteTheme('app-modules/he4rt/resources/css/theme.css')
            ->discoverWidgets(in: app_path('Filament/Guest/Widgets'), for: 'App\Filament\Guest\Widgets')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ]);
    }
}
