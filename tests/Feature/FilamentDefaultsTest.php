<?php

declare(strict_types=1);

use App\Enums\FilamentPanel;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\Width;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use He4rt\User\Filament\Admin\Resources\Users\Pages\ListUsers;

use function Pest\Livewire\livewire;

it('applies the table defaults', function (): void {
    config()->set('he4rt.admins', ['admin']);
    $this->actingAs(User::factory()->create(['username' => 'admin']));
    Filament::setCurrentPanel(FilamentPanel::Admin->value);

    /** @var Table $table */
    $table = livewire(ListUsers::class)->instance()->getTable();

    expect($table)
        ->isLoadingDeferred()->toBeTrue()
        ->persistsSortInSession()->toBeTrue()
        ->persistsSearchInSession()->toBeTrue()
        ->hasExtremePaginationLinks()->toBeTrue()
        ->getPaginationPageOptions()->toBe([10, 25, 50])
        ->getDefaultPaginationPageOption()->toBe(10)
        ->getFiltersFormWidth()->toBe(Width::Medium)
        ->getDefaultDateDisplayFormat()->toBe('d/m/Y')
        ->getDefaultDateTimeDisplayFormat()->toBe('d/m/Y H:i');
});

it('renders selects as searchable non-native dropdowns', function (): void {
    expect(Select::make('status'))
        ->isNative()->toBeFalse()
        ->canSelectPlaceholder()->toBeTrue()
        ->and(SelectFilter::make('status'))
        ->isNative()->toBeFalse();
});

it('renders date time pickers without seconds', function (): void {
    expect(DateTimePicker::make('submitted_at'))
        ->isNative()->toBeFalse()
        ->hasSeconds()->toBeFalse();
});
