<?php

declare(strict_types=1);

namespace App\Providers;

use App\Enums\FilamentPanel;
use App\Filament\Shared\Responses\LogoutResponse as LogoutResponseImpl;
use Filament\Auth\Http\Responses\Contracts\LogoutResponse as LogoutResponseContract;
use Filament\Facades\Filament;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Panel;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\VerticalAlignment;
use Filament\Support\Enums\Width;
use Filament\Support\Facades\FilamentView;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;
use Illuminate\Support\ServiceProvider;

final class FilamentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(LogoutResponseContract::class, LogoutResponseImpl::class);

        $this->configureMacros();
    }

    public function boot(): void
    {
        $this->configureNoIndex();
        $this->configureTable();
        $this->configureSchema();
        $this->configureIconColumn();
        $this->configureSelectFilter();
        $this->configureSelect();
        $this->configureDateTimePicker();
    }

    private function configureMacros(): void
    {
        Panel::macro('currentPanel', function (): FilamentPanel {
            /** @var string $panelId */
            $panelId = $this->getId();

            return FilamentPanel::from($panelId);
        });
    }

    private function configureNoIndex(): void
    {
        FilamentView::registerRenderHook(
            PanelsRenderHook::HEAD_START,
            function (): HtmlString {
                $panel = Filament::getCurrentPanel();

                if ($panel === null || $panel->currentPanel()->isGuest()) {
                    return new HtmlString('');
                }

                return new HtmlString('<meta name="robots" content="noindex, nofollow" />');
            },
        );
    }

    private function configureTable(): void
    {
        Table::configureUsing(fn (Table $table): Table => $table
            ->deferLoading()
            ->persistSortInSession()
            ->persistSearchInSession()
            ->extremePaginationLinks()
            ->defaultPaginationPageOption(10)
            ->paginated([10, 25, 50])
            ->filtersFormWidth(Width::Medium)
            ->emptyStateIcon(Heroicon::OutlinedExclamationTriangle)
            ->defaultDateDisplayFormat('d/m/Y')
            ->defaultDateTimeDisplayFormat('d/m/Y H:i')
            ->defaultTimeDisplayFormat('H:i:s'));
    }

    private function configureSchema(): void
    {
        Schema::configureUsing(fn (Schema $schema): Schema => $schema
            ->defaultDateDisplayFormat('d/m/Y')
            ->defaultDateTimeDisplayFormat('d/m/Y H:i')
            ->defaultTimeDisplayFormat('H:i:s'));
    }

    private function configureIconColumn(): void
    {
        IconColumn::configureUsing(fn (IconColumn $iconColumn): IconColumn => $iconColumn
            ->alignment(Alignment::Center)
            ->verticalAlignment(VerticalAlignment::Center));
    }

    private function configureSelectFilter(): void
    {
        SelectFilter::configureUsing(fn (SelectFilter $selectFilter): SelectFilter => $selectFilter
            ->native(condition: false));
    }

    private function configureSelect(): void
    {
        Select::configureUsing(fn (Select $select): Select => $select
            ->native(condition: false)
            ->selectablePlaceholder(fn (Select $component): bool => !$component->isRequired())
            ->searchable(fn (Select $component): bool => $component->hasRelationship())
            ->preload(fn (Select $component): bool => $component->isSearchable() && !$component->hasRelationship()));
    }

    private function configureDateTimePicker(): void
    {
        DateTimePicker::configureUsing(fn (DateTimePicker $dateTimePicker): DateTimePicker => $dateTimePicker
            ->native(condition: false)
            ->seconds(condition: false)
            ->minDate(now()->subYears(25))
            ->maxDate(now()->addYears(25)));
    }
}
