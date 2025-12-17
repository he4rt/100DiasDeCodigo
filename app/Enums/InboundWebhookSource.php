<?php

declare(strict_types=1);

namespace App\Enums;

use BackedEnum;
use Basement\Webhooks\Contracts\InboundWebhookContract;
use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;

enum InboundWebhookSource: string implements HasColor, HasIcon, HasLabel, InboundWebhookContract
{
    case TwitterApi = 'twitter-api';

    public function getColor(): array
    {
        return match ($this) {
            self::TwitterApi => Color::Teal,
        };
    }

    public function getIcon(): BackedEnum
    {
        return match ($this) {
            self::TwitterApi => Heroicon::PaperAirplane,
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::TwitterApi => 'Twitter API',
        };
    }
}
