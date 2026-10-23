@php
/** @var \Laravel\Boost\Install\GuidelineAssist $assist */
@endphp

# Testing

The suite runs on **Pest 5**. Create tests with `php artisan make:test --pest {name}` (add `--unit` for a unit test). Run them with `php artisan test --compact`. Filter with `--filter=`, `--testsuite=` or `--group=`.

## Module test autoloading — register the `Tests\` namespace of every module in the root

When a module gets a **shared, namespaced test class** (a base `TestCase`, a trait, a fake or fixture in `tests/Support/` or `tests/Entities/`, a dataset), you MUST declare its `He4rt\<Module>\Tests\` namespace in the **root** `composer.json` `autoload-dev.psr-4`. Do it in the **same change**. The `composer.json` of the module alone is not sufficient.

**Why:** Composer never loads the `autoload-dev` of a dependency. `internachi/modular` installs each module as a path-repo dependency, so the `He4rt\<Module>\Tests\ → tests/` map of the module is **inert** in the aggregate build. PHPUnit includes `*Test.php` files by path, so plain test classes still run. A shared class without the `*Test.php` suffix resolves **only** through PSR-4. Without the root entry, it fails with `Class not found`. No tool automates this: `modules:sync` changes only `phpunit.xml`, and upstream declined the feature (`InterNACHI/modular#105`).

@verbatim
<code-snippet name="Root composer.json autoload-dev" lang="json">
{
    "autoload-dev": {
        "psr-4": {
            "He4rt\\IntegrationTwitterApi\\Tests\\": "app-modules/integration-twitter-api/tests/",
            "Tests\\": "tests/"
        }
    }
}
</code-snippet>
@endverbatim

- Put the `Tests\` namespace of a module only in `autoload-dev`, never in `autoload`. Code in `autoload` ships to production.
- Keep **both** blocks: the block of the module (isolated scope, removed by `--no-dev`) and the root block (aggregate suite). Do not delete the block of the module to remove the duplicate. `make:module` creates it again.
- Add one root `psr-4` entry for each module that has a `tests/` directory. Read the prefix from the PSR-4 map of the module. Do not guess it.
- Sort the entries alphabetically, then run `composer dump-autoload`.
- When you run `make:module <slug>`, add its root entry in the same change.

**Verification:** `tests/Arch/ModuleTestNamespacesRegisteredTest.php` fails when a module with a `tests/` directory is missing from the root `autoload-dev`. The failure message prints the exact line to add.

## Structure

Three suites. Each suite is declared in **both** `phpunit.xml` (testsuite `<directory>` globs) and `tests/Pest.php` (the `pest()->…->in(...)` bindings). Each suite covers the root `tests/` directory **and** every `app-modules/*/tests/` directory. Keep the two files in sync when you add a suite.

| Suite     | Location                                       | Binding                                   | DB  |
| --------- | ---------------------------------------------- | ----------------------------------------- | --- |
| `Unit`    | `tests/Unit`, `app-modules/*/tests/Unit`       | group `unit`                              | no  |
| `Feature` | `tests/Feature`, `app-modules/*/tests/Feature` | group `feature` + `LazilyRefreshDatabase` | yes |
| `Arch`    | `tests/Arch`, `app-modules/*/tests/Arch`       | group `arch`                              | no  |

Run one suite with `composer test:unit`, `composer test:feature`, or `php artisan test --compact --group=arch`.

## Architecture test suite (`arch()` + reflection guards)

The `Arch` suite never touches the database (no `RefreshDatabase`).

### Where each rule lives

- **System-wide invariants → `tests/Arch/`.** Readable `arch('…')` rules and reflection guards that apply to all modules (e.g. `ModuleServiceProviderLocationTest`, `ModuleTestNamespacesRegisteredTest`, `NoLooseArrayCastsTest`).
- **Module-specific rules → `app-modules/<slug>/tests/Arch/<Module>ArchTest.php`.** Put the **domain never uses presentation** direction here (e.g. `He4rt\Submission` not→toUse `He4rt\Portal`). Scope a rule to the sub-namespace where it is true.
- **Reflection guards go in `tests/Arch/`, not in `tests/Unit`.** A structural gate written with `test()` and reflection belongs in the `Arch` suite.

### Validate each rule against the real code BEFORE you write it

An arch rule must **pass**. Confirm the fact with `rg` or reflection first. If the fact is not true yet, fix the code (the rule becomes the gate) or do not write the rule. Example: domain enums implement `Filament\Support\Contracts\*` (`He4rt\Submission\Enums\SubmissionStatus`). So "domain does not depend on presentation" forbids the **presentation module namespaces** (`He4rt\Portal`, `He4rt\Core`), never the Filament framework.

### Gotchas

- `phpunit --list-tests` shows fewer `arch()` tests than exist (late registration). Trust the counts of the `--group=arch` run.
- Pest loads all `tests/Arch/*` files in one process. Do not declare a top-level `const` or function name that another Arch file already declares. A duplicate is a fatal error.
- When you rename a namespace, change every `expect('He4rt\X')` and `not->toUse('He4rt\Y')` that names it as a string in the same edit.
