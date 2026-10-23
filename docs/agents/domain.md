# Domain Docs

How the engineering skills should consume this repo's domain documentation when exploring the codebase.

## Before exploring, read these

- **`GLOSSARY-MAP.md`** at the repo root: it points at one `GLOSSARY.md` per module (`he4rt`, `integration-twitter-api`, `portal`, `submission`, `user`). Read each one relevant to the topic.
- **`docs/adr/`**: read ADRs that touch the area you're about to work in. Also check `app-modules/<module>/docs/adr/` for module-scoped decisions.

If any of these files don't exist, **proceed silently**. Don't flag their absence; don't suggest creating them upfront. The `/domain-modeling` skill creates them lazily when terms or decisions actually get resolved.

Use only the names `GLOSSARY.md` and `GLOSSARY-MAP.md`. Never create a `CONTEXT.md` or a `CONTEXT-MAP.md`.

## File structure

This is a multi-context repo (modular monorepo with `internachi/modular`):

```
/
├── GLOSSARY-MAP.md                    ← system-wide glossary map
├── docs/adr/                          ← system-wide decisions
└── app-modules/
    └── <module>/
        ├── GLOSSARY.md
        └── docs/adr/                  ← module-specific decisions
```

## Use the glossary's vocabulary

When your output names a domain concept (in an issue title, a refactor proposal, a hypothesis, a test name), use the term as defined in the module's `GLOSSARY.md`. Don't drift to synonyms the glossary explicitly avoids.

If the concept you need isn't in the glossary yet, that's a signal: either you're inventing language the project doesn't use (reconsider) or there's a real gap (note it for `/domain-modeling`).

## Flag ADR conflicts

If your output contradicts an existing ADR, surface it explicitly rather than silently overriding:

> _Contradicts ADR-0007 (event-sourced orders), but worth reopening because…_
