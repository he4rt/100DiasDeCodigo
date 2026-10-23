@php
/** @var \Laravel\Boost\Install\GuidelineAssist $assist */
@endphp

# Documentation Authoring

This is the **single source of truth for where authored docs live**. Every producer obeys it: a Matt Pocock skill, a superpowers skill, any other tool, or a human. The **scope and type** of the doc decide its destination. The tool that created the doc never decides it.

Read `docs/agents/domain.md` first. It covers `GLOSSARY-MAP.md`, the `GLOSSARY.md` of each module and the `docs/adr/` trees. Create these files only when a decision or a spec is resolved. Do not scaffold them upfront.

## Engineering docs only

This repo has no product knowledge base in `docs/`. All authored docs are **engineering docs** (adr, spec, plan, prd). Do not create `docs/{panel}/` folders.

## Where to save each doc (co-location)

A doc about **one module** lives in that module. A **system-wide or cross-module** doc lives at the repo root:

```
app-modules/{module}/   (module-scoped)    docs/   (system-wide / cross-module)
├── GLOSSARY.md  (glossary)                 ├── adr/
├── README.md    (entry point)              ├── specs/
└── docs/                                   ├── plans/
    ├── adr/                                └── prd/
    ├── specs/
    ├── plans/
    └── prd/
```

## Type → folder → producers

| Type   | Folder    | Produced by (known)                                            |
| ------ | --------- | -------------------------------------------------------------- |
| `adr`  | `adr/`    | `/grill-with-docs`, `/domain-modeling`, superpowers design, human |
| `spec` | `specs/`  | `/to-spec`, `/grill-me`, superpowers brainstorming, human      |
| `plan` | `plans/`  | `/plan`, superpowers plan-writing, human                       |
| `prd`  | `prd/`    | `/to-spec` (PRD mode), product owner, human                    |

**Any other tool follows the same rule.** The *type* decides the folder. The tool decides only the `tool:` field of the header. Never save a doc in a tool-specific folder (e.g. `docs/superpowers/`).

## Front-matter

Start each new doc with this header:

```yaml
---
type: adr | spec | plan | prd
title: <readable title>
status: draft | proposed | accepted | superseded | done
module: <module> | system
created: YYYY-MM-DD
tool: matt-pocock/to-spec | superpowers/brainstorm | human   # provenance
supersedes: docs/adr/0003-....md   # optional
related: [ ... ]                    # optional
---
```

- Do not omit `tool:`. It makes docs from different toolkits interchangeable on disk.
- `status` lifecycle: `draft → proposed → accepted` (adr) or `done` (spec, plan, prd), then `superseded`.
- The new doc sets `supersedes:`. The old doc gets `status: superseded` and a link to the new doc. Never delete a superseded doc.

## Naming

- ADR: `NNNN-kebab-title.md`. Number **per scope**: module ADRs start at `0001` in `app-modules/{module}/docs/adr/`. Root ADRs in `docs/adr/` have their own sequence. Never use one global sequence.
- Spec / Plan / PRD: `YYYY-MM-DD-kebab-title.md` (a PRD can omit the date).

## Ephemeral vs durable

- Docs in `docs/` and `app-modules/{module}/docs/` are **durable**. Commit them.
- Working notes and tool scratch files are **ephemeral**. Keep them out of `docs/`. `.gitignore` ignores `.ai/*`, except `.ai/guidelines/` and `.ai/rules/`.

## README vs GLOSSARY (do not duplicate)

- `GLOSSARY.md` = glossary and module boundaries (conceptual).
- `README.md` = practical entry point and roadmap (concrete). It links to the glossary and the ADRs.
- A module `README.md` **must not** repeat a column/schema table (it lives in the Model PHPDoc), the glossary, or architecture decisions with rationale (they become ADRs).
