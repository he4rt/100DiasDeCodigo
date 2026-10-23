# Labels

Labels are grouped by prefix. Every issue carries one triage label, one `type:*` label and at least one `mod:*` label. `resolution:*` labels are only for closed issues.

## Triage

The skills speak in terms of five canonical triage roles. This table maps those roles to the actual label strings used in this repo's issue tracker.

| Label in skills   | Label in our tracker | Meaning                                  |
| ----------------- | -------------------- | ---------------------------------------- |
| `needs-triage`    | `needs-triage`       | Maintainer needs to evaluate this issue  |
| `needs-info`      | `needs-info`         | Waiting on reporter for more information |
| `ready-for-agent` | `ready-for-agent`    | Fully specified, ready for an AFK agent  |
| `ready-for-human` | `ready-for-human`    | Requires human implementation            |
| `wontfix`         | `wontfix`            | Will not be actioned                     |

When a skill mentions a role (e.g. "apply the AFK-ready triage label"), use the corresponding label string from this table.

Triage labels stay unprefixed because the skills match these exact strings.

## Type

Follows the Conventional Commit type of the change.

| Label           | Meaning                        |
| --------------- | ------------------------------ |
| `type:feat`     | New feature                    |
| `type:fix`      | Bug fix                        |
| `type:refactor` | Code refactoring               |
| `type:docs`     | Documentation                  |
| `type:chore`    | Maintenance / tooling          |
| `type:spec`     | Spec / epic, parent of tickets |

## Module

Follows the Conventional Commit scope. One label per area the issue touches.

Each `app-modules/<slug>/` has exactly one `mod:<slug>` label. `mod:agents` and `mod:infra` cover the areas outside `app-modules/`.

| Label                         | Area                                                    |
| ----------------------------- | ------------------------------------------------------- |
| `mod:he4rt`                   | `app-modules/he4rt` — theme and shared views            |
| `mod:integration-twitter-api` | `app-modules/integration-twitter-api` — Twitter API client and webhooks |
| `mod:portal`                  | `app-modules/portal` — public pages (`guest` panel)     |
| `mod:submission`              | `app-modules/submission` — challenge submissions and review |
| `mod:user`                    | `app-modules/user` — participants and their submissions |
| `mod:agents`                  | `docs/agents`, `.ai/guidelines`, `.ai/rules`            |
| `mod:infra`                   | CI, Docker, Cloudflare, dependencies                    |

For a new area, create the label first and add a row to this table:

```bash
gh label create "mod:<name>" --description "<short description>" --color "c2e0c6"
```

When you scaffold a new module, add its row and create its label in the same change.

## Resolution

Reason for closing an issue that was not implemented. `wontfix` (triage) covers the "will not do it" case.

| Label                  | Meaning                          |
| ---------------------- | -------------------------------- |
| `resolution:duplicate` | Duplicate of another issue or PR |
| `resolution:invalid`   | Not valid or not reproducible    |

## Difficulty

| Label                | Estimate  | Meaning                                      |
| -------------------- | --------- | -------------------------------------------- |
| `difficulty:trivial` | < 1 day   | Deletion, config changes, scripts            |
| `difficulty:easy`    | 1-2 days  | One model or action, well-defined scope      |
| `difficulty:medium`  | 3-5 days  | Many files, Filament UI, moderate complexity |
| `difficulty:hard`    | 1-2 weeks | Cross-module, complex logic, many panels     |
| `difficulty:epic`    | 2+ weeks  | A complete new system, major refactors       |

Issues tagged `difficulty:trivial` or `difficulty:easy` also get `good first issue`.

## Title convention

Issue and PR titles follow Conventional Commits with the module as scope:

```
<type>(<module>): <short description>
```

Tickets from `/to-tickets` keep their order prefix: `T2 — feat(<module>): <subject>`. A spec uses `Spec: <subject>`.
