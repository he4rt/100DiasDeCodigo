<?php

declare(strict_types=1);

namespace He4rt\Portal\Pages;

use App\Models\User;
use Filament\Pages\Dashboard;
use Filament\Support\Enums\Width;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;

class PortalPage extends Dashboard
{
    protected string $view = 'portal::homepage';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $title = 'Desafio';

    protected string $description = 'Um desafio simples, consistente e transformador. Dedique 1 hora por dia durante 100 dias e mude sua carreira.';

    protected string $coverImage;

    protected string $url;

    protected static ?string $navigationLabel = 'Portal';

    protected Width|string|null $maxContentWidth = Width::Full;

    public function mount(): void
    {
        $this->coverImage = asset('images/portal-cover.png');
        $this->url = url()->current();

        $this->registerMetaTags();
    }

    public function getHeading(): string
    {
        return '';
    }

    public function getSubheading(): ?string
    {
        return null;
    }

    protected function registerMetaTags(): void
    {
        FilamentView::registerRenderHook(
            PanelsRenderHook::HEAD_START,
            fn (): string => Blade::render('portal::components.head.meta-tags', [
                'url' => $this->url,
                'title' => $this->getTitle(),
                'description' => $this->description,
                'coverImage' => $this->coverImage,
            ]),
        );
    }

    protected function getViewData(): array
    {
        return [
            'users' => User::query()
                ->latest()
                ->limit(5)
                ->get(),
            'usersCount' => User::query()->count(),
        ];
    }
}
