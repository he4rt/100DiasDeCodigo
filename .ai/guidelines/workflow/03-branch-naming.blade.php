@php
/** @var \Laravel\Boost\Install\GuidelineAssist $assist */
@endphp

# Branch Naming & Git Workflow

Agents MUST create branches with the canonical prefixes below. CI is a **merge gate** defined in `.github/workflows/continuous-integration.yml`. It runs on a pull request only when the **base** (target) branch of the PR matches one of these patterns. A PR target outside this convention gets **no pipeline**.

## Canonical branch prefixes

| Prefix                 | Use for                                         | Commit type   |
| ---------------------- | ----------------------------------------------- | ------------- |
| `feature/<slug>`       | New features                                    | `feat`        |
| `bugfix/<slug>`        | Bug fixes                                       | `fix`         |
| `chore/<slug>`         | Maintenance, dependencies, tooling, config, CI  | `chore`       |
| `story/<issue>-<slug>` | Issue-driven work (a GitHub issue is open)      | fits the work |

- `<slug>` is lowercase kebab-case, e.g. `feature/public-ranking-page`.
- `story/` includes the issue number, e.g. `story/42-reject-propaganda-tweets`.
- The prefixes map to the `type:` labels in the Triage Labels guideline.
- CI also accepts `feat/**` as a base. Do not create new `feat/` branches. Use `feature/`.

## Base / integration branches

Each PR targets one of these bases. CI runs only for these patterns:

| Base pattern                                               | Meaning                                              |
| ---------------------------------------------------------- | ---------------------------------------------------- |
| `<major>.x`                                                | Release lines (`1.x` is the default branch)          |
| `feature/**` `feat/**` `bugfix/**` `chore/**` `story/**`   | Long-lived integration branches that receive sub-PRs |

Long-lived integration branches use the **same prefixes**. Sub-work goes into them with a PR (e.g. `story/42-reject-propaganda-tweets → feature/submission-review`). Later, the integration branch merges into a `<major>.x` line.

## Rules for agents

- Create the branch from the correct base, with a canonical prefix. Never push work directly to a `<major>.x` line.
- Commit subjects follow conventional commits with the module as scope (`<type>(<module>): ...`). See the Title Convention in the Triage Labels guideline.
- CI runs only on PRs and on pushes to `<major>.x`. CI skips draft PRs. Open a non-draft PR, or mark it ready for review, to start the pipeline.
- Keep this table in sync with the `pull_request.branches` filter in `.github/workflows/continuous-integration.yml`. If you change one and not the other, the merge gate drifts.
