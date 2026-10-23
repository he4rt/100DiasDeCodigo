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

final class GoToAppAction extends Action
{
    protected string|Htmlable|Closure|null $label = 'Ir para o aplicativo';

    protected string|Closure|Htmlable|null|false|BackedEnum $icon = Heroicon::OutlinedCursorArrowRays;

    protected function setUp(): void
    {
        parent::setUp();

        $this->url(fn () => url(Filament::getPanel(FilamentPanel::App->value)->getUrl()));
    }

    public static function getDefaultName(): string
    {
        return 'go-to-app';
    }
}
