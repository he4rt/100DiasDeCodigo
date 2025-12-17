<?php

declare(strict_types=1);

use App\Enums\InboundWebhookSource;
use Basement\Webhooks\Models\InboundWebhook;
use Filament\Support\Icons\Heroicon;

return [
    'navigation_group' => 'Logs',
    'navigation_label' => 'Webhooks',
    'navigation_icon_inactive' => Heroicon::OutlinedBell,
    'navigation_icon_active' => Heroicon::Bell,
    'navigation_sort' => 100,

    'model' => InboundWebhook::class,
    'providers_enum' => InboundWebhookSource::class,
];
