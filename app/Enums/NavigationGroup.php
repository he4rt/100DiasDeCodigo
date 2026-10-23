<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;

/**
 * Sidebar groups of the admin panel. The order of the cases is the order of the groups.
 */
enum NavigationGroup implements HasIcon, HasLabel
{
    case Challenge;

    case Logs;

    public function getLabel(): string
    {
        return match ($this) {
            self::Challenge => 'Challenge',
            self::Logs => 'Logs',
        };
    }

    public function getIcon(): Heroicon
    {
        return match ($this) {
            self::Challenge => Heroicon::OutlinedTrophy,
            self::Logs => Heroicon::OutlinedInboxArrowDown,
        };
    }
}
