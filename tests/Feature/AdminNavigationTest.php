<?php

declare(strict_types=1);

use App\Enums\FilamentPanel;
use App\Enums\NavigationGroup as AdminNavigationGroup;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;

beforeEach(function (): void {
    config()->set('he4rt.admins', ['admin']);
    $this->actingAs(User::factory()->create(['username' => 'admin']));

    Filament::setCurrentPanel(FilamentPanel::Admin->value);
});

/**
 * @return array<string, list<string>>
 */
function adminNavigation(): array
{
    $navigation = [];

    /** @var NavigationGroup $group */
    foreach (Filament::getPanel(FilamentPanel::Admin->value)->getNavigation() as $group) {
        $navigation[(string) ($group->getLabel() ?? '')] = collect($group->getItems())
            ->map(static fn (NavigationItem $item): string => (string) $item->getLabel())
            ->values()
            ->all();
    }

    return $navigation;
}

it('groups the admin navigation in the enum order', function (): void {
    expect(adminNavigation())->toBe([
        '' => ['Dashboard'],
        AdminNavigationGroup::Challenge->getLabel() => ['Submissions', 'Users'],
        AdminNavigationGroup::Logs->getLabel() => ['Webhooks'],
    ]);
});

it('takes the group icons from the enum', function (): void {
    $icons = collect(Filament::getPanel(FilamentPanel::Admin->value)->getNavigation())
        ->filter(fn (NavigationGroup $group): bool => filled($group->getLabel()))
        ->mapWithKeys(fn (NavigationGroup $group): array => [(string) $group->getLabel() => $group->getIcon()])
        ->all();

    expect($icons)->toBe([
        AdminNavigationGroup::Challenge->getLabel() => AdminNavigationGroup::Challenge->getIcon(),
        AdminNavigationGroup::Logs->getLabel() => AdminNavigationGroup::Logs->getIcon(),
    ]);
});
