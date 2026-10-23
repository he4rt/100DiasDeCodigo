<?php

declare(strict_types=1);

use Filament\Facades\Filament;
use Filament\Panel;

arch('exactly one filament panel is the default', function (): void {
    $defaultPanels = collect(Filament::getPanels())
        ->filter(fn (Panel $panel): bool => $panel->isDefault())
        ->keys()
        ->all();

    expect($defaultPanels)->toBe(['guest']);
});
