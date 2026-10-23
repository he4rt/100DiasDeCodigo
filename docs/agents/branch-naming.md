# Branch naming

All work goes through a branch and a PR. Never push directly to a `<major>.x` line.

## Prefixes

| Prefix                 | Use for                                        | Commit type   |
| ---------------------- | ---------------------------------------------- | ------------- |
| `feature/<slug>`       | New features                                   | `feat`        |
| `bugfix/<slug>`        | Bug fixes                                      | `fix`         |
| `chore/<slug>`         | Maintenance, dependencies, tooling, config, CI, agent docs | `chore` |
| `story/<issue>-<slug>` | Issue-driven work (a GitHub issue is open)     | fits the work |

- `<slug>` is lowercase kebab-case, e.g. `feature/public-ranking-page`.
- `story/` embeds the issue number, e.g. `story/42-reject-propaganda-tweets`. Prefer it whenever the work has an issue.
- The prefix matches the `type:*` label of the issue and the PR.
- CI also accepts `feat/**` as a base. Do not create new `feat/` branches. Use `feature/`.

## Base branches

CI (`.github/workflows/continuous-integration.yml`) runs on a PR only when its **base** branch matches one of these patterns. A PR to any other base gets **no pipeline**.

| Base pattern                                             | Meaning                                              |
| -------------------------------------------------------- | ---------------------------------------------------- |
| `<major>.x`                                              | Release lines (`1.x` is the default branch)          |
| `feature/**` `feat/**` `bugfix/**` `chore/**` `story/**` | Long-lived integration branches that receive sub-PRs |

Sub-work goes into an integration branch with a PR (e.g. `story/42-reject-propaganda-tweets → feature/submission-review`). Later, the integration branch merges into a `<major>.x` line.

Branch off an up-to-date `origin/<base>`, not a local base that may carry unpushed commits.

Keep this table in sync with the `pull_request.branches` filter in `.github/workflows/continuous-integration.yml`. If you change one and not the other, the merge gate drifts.
