@php
/** @var \Laravel\Boost\Install\GuidelineAssist $assist */
@endphp

## Agent skills

The workflow docs live as static files in `docs/agents/`. Read the file that matches the task before you act. These paths are a contract: the engineering skills read them by name.

| Read this                       | When you                                                                                     |
| ------------------------------- | -------------------------------------------------------------------------------------------- |
| `docs/agents/issue-tracker.md`  | create, read, label or close an issue; start an issue (`@me`); open a PR; set sub-issues or `blocked_by` |
| `docs/agents/triage-labels.md`  | pick or create a label (triage, `type:*`, `mod:*`, `resolution:*`, `difficulty:*`); write an issue or PR title |
| `docs/agents/branch-naming.md`  | create a branch or choose the base of a PR                                                   |
| `docs/agents/domain.md`         | explore the codebase; name a domain concept; touch an area with ADRs                         |

### Issue tracker

GitHub Issues in `he4rt/100DiasDeCodigo`, via the `gh` CLI. PRs link an issue, are assigned to the implementer (`@me`) and copy the issue's labels; an issue is assigned to the implementer when implementation starts. See `docs/agents/issue-tracker.md`.

### Triage labels

The five canonical triage roles, each label string equal to its name, plus `type:*`, `mod:*`, `resolution:*` and `difficulty:*` labels and the title convention. See `docs/agents/triage-labels.md`.

### Branch naming

`feature/`, `bugfix/`, `chore/`, `story/<issue>-<slug>`, always off an up-to-date `origin/<base>`; CI runs only for the bases in the table. See `docs/agents/branch-naming.md`.

### Domain docs

Multi-context: `GLOSSARY-MAP.md` at the repo root maps each module to its `app-modules/<module>/GLOSSARY.md`; ADRs in `docs/adr/` (system-wide) and `app-modules/<module>/docs/adr/`. See `docs/agents/domain.md`.
