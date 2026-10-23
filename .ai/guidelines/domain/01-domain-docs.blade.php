@php
/** @var \Laravel\Boost\Install\GuidelineAssist $assist */
@endphp

# Domain Docs

How to use the domain documentation of this repo when you explore the codebase.

## Before you explore, read these

- **`GLOSSARY-MAP.md`** at the repo root. It points to one `GLOSSARY.md` per module. Read each one that is related to the topic.
- **`docs/adr/`**. Read the ADRs that touch the area you work in. Also check `app-modules/<module>/docs/adr/` for module-scoped decisions.

If one of these files does not exist, **continue silently**. Do not flag that it is missing. Do not suggest to create it upfront. The producer skill (`/grill-with-docs`, `/domain-modeling`) creates it when a term or a decision is resolved.

Use only the names `GLOSSARY.md` and `GLOSSARY-MAP.md`. Never create a `CONTEXT.md` or a `CONTEXT-MAP.md`.

## File structure

This is a multi-context repo (modular monorepo with `internachi/modular`):

```
/
├── GLOSSARY-MAP.md                        <- system-wide glossary map
├── docs/adr/                              <- system-wide decisions
└── app-modules/
    ├── submission/
    │   ├── GLOSSARY.md
    │   └── docs/adr/                      <- module-specific decisions
    ├── user/
    │   ├── GLOSSARY.md
    │   └── docs/adr/
    ├── integration-twitter-api/
    │   ├── GLOSSARY.md
    │   └── docs/adr/
    └── ...
```

## Use the vocabulary of the glossary

When your output names a domain concept (an issue title, a refactor proposal, a hypothesis, a test name), use the term that `GLOSSARY.md` defines. Do not use a synonym that the glossary tells you to avoid.

If the concept is not in the glossary yet, stop and think. You invent language that the project does not use (reconsider), or there is a real gap (note it for `/grill-with-docs`).

## Flag ADR conflicts

If your output contradicts an ADR, say so explicitly. Do not override the ADR silently:

> _Contradicts ADR-0007 — but worth reopening because..._
