@php
/** @var \Laravel\Boost\Install\GuidelineAssist $assist */
@endphp

# PHPStan — ignoreErrors Conventions

The root `phpstan.neon` includes `phpstan.modules.php`, which loads every `app-modules/*/phpstan.neon`. Each module config includes its own `phpstan.ignore.neon`. Run PHPStan from the repo root over the whole project: `composer test:phpstan` or `make phpstan`.

When you add an entry to `ignoreErrors` in a `phpstan.neon` or `phpstan.ignore.neon` file, always use the **indented block style**: a `-` alone on its line, with the keys indented below it. Never use the inline `- { ... }` style. It needs horizontal scrolling and is hard to read.

## Correct format

@verbatim
<code-snippet name="ignoreErrors block style" lang="neon">
parameters:
    ignoreErrors:
        -
            message: '#^Error message regex here#'
            identifier: error.identifier
            count: 1
            path: src/Path/To/File.php
</code-snippet>
@endverbatim

## Rules

- `message` must be a regex between `#` delimiters.
- Always scope the entry to one `path`. Never write an entry without a `path`.
- Always include `count`, so PHPStan warns when the number of occurrences changes.
- Always include `identifier` when PHPStan gives one (e.g. `property.notFound`).
- Do not escape spaces with `\ ` inside a `#...#` regex.
- Fix the root cause first. Ignore an error only when:
    - The error comes from third-party or generated code.
    - The false positive is a known PHPStan/Larastan limitation (e.g. Livewire `$form`).

## Third-party stubs

Some vendor libraries ship stubs with types wider than the runtime value: a union where the runtime value is always one branch, or a nullable that is never null. A method call that exists only on the real branch is valid at runtime, but PHPStan flags it (`method.nonObject`, `property.notFound`, …).

Policy for these errors:

- Do **not** change working runtime code to satisfy a wrong stub.
- Suppress the error in the **module-scoped** `phpstan.ignore.neon` (e.g. `app-modules/<module>/phpstan.ignore.neon`). Never use the root `phpstan.ignore.neon` for a module error. The suppression stays next to the affected module.
- Use the indented block style, scope to the `path`, pin the `count`, and include the `identifier`, as for all other entries.

## Baseline

For a large set of legacy errors, run `{{ $assist->binCommand('phpstan analyse --generate-baseline') }}`. Keep manual `ignoreErrors` entries for intentional, documented suppressions only.
