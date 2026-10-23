@php
/** @var \Laravel\Boost\Install\GuidelineAssist $assist */
@endphp

# Presentation Layer

The `portal` and `he4rt` modules are the **presentation layer**. `portal` holds the public pages of the `guest` panel. `he4rt` holds the shared theme, fonts, views and the base Filament page.

## Filament panels

| Panel   | Path     | Provider                                        |
| ------- | -------- | ----------------------------------------------- |
| `admin` | `/admin` | `app/Providers/Filament/AdminPanelProvider.php` |
| `app`   | `/app`   | `app/Providers/Filament/AppPanelProvider.php`   |
| `guest` | `/`      | `app/Providers/Filament/GuestPanelProvider.php` |

A module adds UI to a panel from its ServiceProvider with `Panel::configureUsing()`. It registers a panel plugin (e.g. `He4rt\Submission\AdminSubmissionPanelPlugin`) or calls `discoverResources()` for that panel id. Put the panel UI of a module in `src/Filament/{Admin,App}/`, one folder per panel.

## Rule

Filament classes own UI concerns only. Domain logic (Actions, Models, DTOs, business rules) belongs in the domain layer of the module, never in a Resource, Page, Widget or Livewire component.

Presentation modules import from domain modules. Domain modules never import from presentation modules.

## Filament rules

Filament 5 is installed. Before you implement, research Filament 5.x with the `search-docs` MCP tool and activate the `filament-development` skill.

In Filament Pages, Resources, Widgets and Livewire components, import domain classes with a `use` statement. This keeps the presentation layer decoupled from domain logic.

For a Filament Action, create an Action class that calls the Domain Action. The Filament Action keeps only the UI logic.

@verbatim
<code-snippet name="Filament Action wrapping a Domain Action" lang="php">
class NewSubmissionAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label('New Submission')
            ->icon(Heroicon::PlusCircle)
            ->color(Color::Sky)
            ->modalHeading('New Submission')
            ->modalWidth(Width::ThreeExtraLarge)
            ->schema([
                TextInput::make('tweet_url')->url()->required(),
            ])
            ->action(function (array $data): void {
                resolve(SomeDomainAction::class)->execute(SomeDto::fromArray($data));

                Notification::make()
                    ->success()
                    ->send();
            });
    }
}
</code-snippet>
@endverbatim

## Styling

Tailwind CSS is installed. Activate the `tailwindcss-development` skill for styling work. Test dark mode. Do not hardcode `bg-white`.
