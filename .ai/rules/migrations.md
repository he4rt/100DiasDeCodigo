---
paths:
  - 'database/migrations/**'
  - 'app-modules/*/database/migrations/**'
---

# Migrations

## Migrations are forward-only — no down() method

Do not write a `down()` method in a new migration. `make:migration` scaffolds one by default — delete it, leaving only `up()`. This project treats migrations as forward-only: schema is never rolled back with `migrate:rollback`; you re-migrate from a fresh state instead. A `down()` method is dead code that implies a rollback path we do not support. Applies to `database/migrations/` and to every module's `database/migrations/`.

Older migrations still have a `down()`. When you remove a `down()` from an existing migration, also delete any `private`/`protected` helper methods that only `down()` called — once `down()` is gone they are unreachable dead code.

## Create migrations with Artisan and the module flag

Always create migrations with `php artisan make:migration`, never by hand. In this modular monorepo every module migration MUST pass `--module=<module>`, which places the file in `app-modules/<module>/database/migrations/` — e.g. `make:migration create_x_table --module=submission`. A migration without `--module` lands in the root `database/migrations/`.

## Date/time columns are timezone-aware

The database is PostgreSQL. Every new date/time column MUST use the `Tz` variant. PostgreSQL stores `timestamptz` as an absolute UTC instant; the non-tz type stores a naive datetime, loses the timezone and causes ±3h display bugs.

| Never | Always |
|-------|--------|
| `timestamp('col')` | `timestampTz('col')` |
| `timestamps()` | `timestampsTz()` |
| `softDeletes()` | `softDeletesTz()` |
| `dateTime('col')` | `dateTimeTz('col')` |
| `nullableTimestamps()` | `timestampsTz()` with `->nullable()` |

Do not edit a migration that already ran in production to change a column type. Write a new migration that alters the column.
