<?php

declare(strict_types=1);

namespace App\Filament\Shared\Actions;

use App\Enums\FilamentPanel;
use BackedEnum;
use Closure;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

final class GoToAdminAction extends Action
{
    protected string|Htmlable|Closure|null $label = 'Ir para o administrativo';

    protected string|Closure|Htmlable|null|false|BackedEnum $icon = Heroicon::OutlinedBuildingOffice2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->visible(fn () => auth()->user()?->isAdmin());
        $this->url(fn () => url(Filament::getPanel(FilamentPanel::Admin->value)->getUrl()));
    }

    public static function getDefaultName(): string
    {
        return 'go-to-admin';
    }
}
