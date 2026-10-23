@php
/** @var \Laravel\Boost\Install\GuidelineAssist $assist */
@endphp

# Module Architecture

This monorepo uses `internachi/modular`. Each module lives in `app-modules/{kebab-case}/` with the namespace `He4rt\{PascalCase}\`.

The namespace is the PascalCase of the slug: `submission` → `He4rt\Submission`, `integration-twitter-api` → `He4rt\IntegrationTwitterApi`. If you are not sure, read the PSR-4 map in the `composer.json` of the module.

Exception: the `he4rt` module uses the namespace `He4rt\Core` (package `he4rt/he4rt-core`).

## Module types

| Type             | Modules                              | Contains                                             |
| ---------------- | ------------------------------------ | ---------------------------------------------------- |
| **Domain**       | `submission`, `user`                 | Business logic: Models, Actions, DTOs, Enums, Jobs   |
| **Integration**  | `integration-*` (`integration-twitter-api`) | External APIs: client, endpoints, DTOs, webhooks |
| **Presentation** | `portal`, `he4rt`                    | UI: public pages, theme, shared views and assets     |

`portal` holds the public pages of the `guest` panel. `he4rt` holds the shared design system (theme, fonts, base Filament page, shared views).

The Filament panels (`admin`, `app`, `guest`) are defined in `app/Providers/Filament/`. A domain module can register Filament UI for its own models in `src/Filament/{Admin,App}/`. See the `presentation/core` guideline.

The `User` model lives in `app/Models/User.php`, not in the `user` module.

## Canonical structure

```
app-modules/{module}/
├── composer.json
├── phpstan.neon
├── phpstan.ignore.neon
├── config/{module}.php                       (optional)
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── routes/{topic}.php                        (optional, auto-discovered)
├── resources/views/                          (optional)
├── src/
│   ├── {ModuleName}ServiceProvider.php       <- always at src/ root, never in Providers/
│   ├── Actions/
│   ├── Models/
│   ├── DTOs/                                 <- data-transfer objects (no behavior)
│   ├── Data/                                 <- value objects (value + validation)
│   ├── Enums/
│   ├── Exceptions/
│   ├── Concerns/
│   ├── Contracts/
│   ├── Filament/{Admin,App}/                 (optional, panel UI of the module)
│   └── ...
├── tests/
│   ├── Arch/
│   ├── Feature/
│   └── Unit/
├── GLOSSARY.md                               (optional)
└── docs/adr/                                 (optional)
```

## Sub-namespace strategies

**Flat layers** — simple modules:
`src/Actions/`, `src/Models/`, `src/DTOs/`, `src/Data/`

`DTOs/` vs `Data/` — split by intent, not by folder preference:

- **`DTOs/`** holds **data-transfer objects**. Their only job is to carry values across a boundary (an API payload, a request, a command input). No behavior, no invariants. Example: the `integration-twitter-api` DTOs (`TweetDTO`, `UserDTO`), which only map the API payload with `fromArray()`.
- **`Data/`** holds **value objects**. A value object owns its state and its validation. It is immutable, it validates itself in the constructor, and it has behavior over the value.

A type that validates or has behavior goes in `Data/`. A bag of fields that only moves data goes in `DTOs/`. `Data/` is not a legacy name for `DTOs/`. The two layers can exist in the same module.

**Sub-domain grouping** — complex modules:
`src/{SubDomain}/Actions/`, `src/{SubDomain}/Models/`

Use this when one module holds more than one sub-domain. No module uses it today.

## ServiceProvider

Always at `src/{ModuleName}ServiceProvider.php`, with the root namespace `He4rt\{ModuleName}`. Never in `src/Providers/`. A file in `src/Providers/` with the root namespace breaks PSR-4. `submission` (`src/SubmissionServiceProvider.php`) follows this rule. Some older modules still have the provider in `src/Providers/`. Do not copy that layout.

Minimal pattern:

@verbatim
<code-snippet name="Module ServiceProvider" lang="php">
namespace He4rt\{ModuleName};

use Filament\Panel;
use Illuminate\Support\ServiceProvider;

class {ModuleName}ServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Panel::configureUsing(fn (Panel $panel) => match ($panel->getId()) {
            'admin' => $panel->plugin(new Admin{ModuleName}PanelPlugin),
            default => null,
        });
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
</code-snippet>
@endverbatim

Add `mergeConfigFrom()`, `loadViewsFrom()`, `Event::listen()`, `Relation::morphMap()` when necessary. Read the ServiceProvider of a sibling module for the full pattern.

## Module composer.json

@verbatim
<code-snippet name="Module composer.json" lang="json">
{
    "name": "he4rt/{module-slug}",
    "autoload": {
        "psr-4": {
            "He4rt\\{ModuleName}\\": "src/",
            "He4rt\\{ModuleName}\\Database\\Factories\\": "database/factories/",
            "He4rt\\{ModuleName}\\Database\\Seeders\\": "database/seeders/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "He4rt\\{ModuleName}\\Tests\\": "tests/"
        }
    }
}
</code-snippet>
@endverbatim

Put the `Tests\` namespace only in `autoload-dev`, never in `autoload`. Also register it in the root `composer.json`. See the `tooling/testing` guideline.

## Dependency rules

- **Domain** modules never import from **presentation** modules (`portal`, `he4rt`).
- **Presentation** modules import from domain and integration modules. The reverse is not permitted.
- **Integration** modules wrap one external API. `submission` consumes the DTOs of `integration-twitter-api` (`TweetDTO`) to create submissions.
- Read `GLOSSARY-MAP.md` (when it exists) for cross-context constraints.

## Register a new module — mandatory label sync

Each `app-modules/<slug>/` has exactly one `mod:<slug>` triage label, and the reverse. When you scaffold a **new** module, in the same change you MUST:

1. **Add a row** to the module table in `workflow/triage-labels` (`mod:<slug>` → `<slug>`).
2. **Create the label on GitHub**:
   `gh label create "mod:<slug>" --color "c2e0c6" --description "<short description>"`
3. **Register the test namespace** in the root `composer.json` `autoload-dev` (see `tooling/testing`).

Keep the guideline table and the GitHub labels in sync. If an issue cannot get the label of its module, triage and routing break.
