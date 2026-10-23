@php
/** @var \Laravel\Boost\Install\GuidelineAssist $assist */
@endphp

# Triage Labels

The skills use five canonical triage roles. This table maps each role to the label string in the issue tracker of this repo.

| Label in skills   | Label in our tracker | Meaning                                    |
| ----------------- | -------------------- | ------------------------------------------ |
| `needs-triage`    | `needs-triage`       | A maintainer must evaluate this issue      |
| `needs-info`      | `needs-info`         | Waiting for more information from reporter |
| `ready-for-agent` | `ready-for-agent`    | Fully specified, ready for an AFK agent    |
| `ready-for-human` | `ready-for-human`    | A human must implement it                  |
| `wontfix`         | `wontfix`            | Will not be done                           |

When a skill names a role (e.g. "apply the AFK-ready triage label"), use the label string from this table.

Some labels in this taxonomy do not exist on GitHub yet. Before you apply a missing label, create it with `gh label create` (see `workflow/issue-tracker`).

---

# Type Labels

The issue type follows the conventional commit prefixes.

| Label           | Meaning                       |
| --------------- | ----------------------------- |
| `type:feat`     | New feature                   |
| `type:fix`      | Bug fix                       |
| `type:refactor` | Code refactoring              |
| `type:docs`     | Documentation                 |
| `type:prd`      | Product Requirements Document |
| `type:chore`    | Maintenance / tooling         |

---

# Module Labels

Tag each issue with the module(s) it affects. The labels use the pattern `mod:<module-name>`, equal to the directory name in `app-modules/`.

| Label                         | Module directory          | Description                          |
| ----------------------------- | ------------------------- | ------------------------------------ |
| `mod:he4rt`                   | `he4rt`                   | Core: theme and shared views         |
| `mod:integration-twitter-api` | `integration-twitter-api` | Twitter API client and webhooks      |
| `mod:portal`                  | `portal`                  | Public portal pages (`guest` panel)  |
| `mod:submission`              | `submission`              | Challenge submissions and review     |
| `mod:user`                    | `user`                    | Participants and their submissions   |

When you create an issue for a new module that has no label yet, create the label first (`gh label create "mod:<name>" --description "<short description>" --color "c2e0c6"`). Then add a row to this table.

---

# Difficulty Labels

Tag each issue that can be implemented with a difficulty estimate.

| Label                | Estimate  | Meaning                                         |
| -------------------- | --------- | ----------------------------------------------- |
| `difficulty:trivial` | < 1 day   | Deletion, config changes, scripts               |
| `difficulty:easy`    | 1-2 days  | One model or action, well-defined scope         |
| `difficulty:medium`  | 3-5 days  | Many files, Filament UI, moderate complexity    |
| `difficulty:hard`    | 1-2 weeks | Cross-module, complex logic, many panels        |
| `difficulty:epic`    | 2+ weeks  | A complete new system, major refactors          |

Also tag `difficulty:trivial` and `difficulty:easy` issues with `good first issue`, so new contributors find them.

---

# Title Convention

Issue titles follow **conventional commits** with the module as scope:

```
<type>(<module>): <short description in English>
```

Examples:
- `feat(submission): reject submissions without the challenge hashtag`
- `fix(integration-twitter-api): webhook rejects valid signatures`
- `refactor(user): move submission refresh into a domain action`
- `prd(portal): public participant ranking`
