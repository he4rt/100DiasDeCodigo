<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Casts\AsEncryptedArrayObject;
use Illuminate\Database\Eloquent\Casts\AsEncryptedCollection;
use Illuminate\Database\Eloquent\Casts\AsEnumArrayObject;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Finder\Finder;

/**
 * Reflete sobre todo model concreto do repo, lê o `getCasts()` real já mesclado
 * e falha em qualquer cast banido fora da allowlist.
 *
 * A allowlist é escape hatch documentado, não arquivo de despejo: cada entrada
 * carrega o motivo e deve tender a zero. Uma linha nova exige justificar por
 * que aquele JSON é genuinamente polimórfico.
 */

/**
 * Casts banidos. Strings são comparadas por igualdade; nomes de classe também
 * casam com a forma parametrizada (`AsEnumCollection:App\Enums\Foo`).
 *
 * @var list<string>
 */
const BANNED_CASTS = [
    'array',
    'json',
    'object',
    'collection',
    'encrypted:array',
    'encrypted:collection',
    'encrypted:object',
    AsArrayObject::class,
    AsCollection::class,
    AsEnumArrayObject::class,
    AsEnumCollection::class,
    AsEncryptedArrayObject::class,
    AsEncryptedCollection::class,
];

/**
 * Dívida existente. Formato:
 * FQCN do model => [coluna => motivo].
 *
 * @var array<class-string<Model>, array<string, string>>
 */
const ALLOWED_LOOSE_CASTS = [];

/**
 * Todo model concreto de `app/Models` e `app-modules/{module}/src`.
 *
 * @return list<class-string<Model>>
 */
function concreteModels(): array
{
    $roots = array_filter([
        base_path('app/Models'),
        ...glob(base_path('app-modules/*/src')) ?: [],
    ], is_dir(...));

    if ($roots === []) {
        return [];
    }

    $models = [];

    foreach (Finder::create()->files()->in($roots)->name('*.php') as $file) {
        $source = $file->getContents();

        if (!preg_match('/^namespace\s+([^;]+);/m', $source, $ns)) {
            continue;
        }

        if (!preg_match('/^(?:final\s+|abstract\s+)*class\s+(\w+)/m', $source, $cls)) {
            continue;
        }

        $fqcn = mb_trim($ns[1]).'\\'.$cls[1];

        if (!class_exists($fqcn)) {
            continue;
        }

        $reflection = new ReflectionClass($fqcn);

        if ($reflection->isAbstract() || !$reflection->isSubclassOf(Model::class)) {
            continue;
        }

        $models[] = $fqcn;
    }

    sort($models);

    return $models;
}

/** O cast está na lista de banidos? Cobre a forma parametrizada `Classe:arg`. */
function isBannedCast(string $cast): bool
{
    $bare = str_contains($cast, ':') ? mb_strstr($cast, ':', before_needle: true) : $cast;

    return in_array($cast, BANNED_CASTS, strict: true) || in_array($bare, BANNED_CASTS, strict: true);
}

arch('encontra models para inspecionar', function (): void {
    // Sem esta guarda, um erro de caminho faria o teste passar sem olhar nada.
    expect(concreteModels())->not->toBeEmpty();
});

arch('não permite cast de array solto fora da allowlist', function (): void {
    $violations = [];

    foreach (concreteModels() as $model) {
        $allowed = ALLOWED_LOOSE_CASTS[$model] ?? [];

        foreach ((new $model)->getCasts() as $attribute => $cast) {
            if (!is_string($cast) || !isBannedCast($cast)) {
                continue;
            }

            if (array_key_exists($attribute, $allowed)) {
                continue;
            }

            $violations[] = sprintf('%s::$%s => %s', $model, $attribute, $cast);
        }
    }

    expect($violations)->toBe([], sprintf(
        "Cast de array solto sem allowlist:\n  %s\n\n"
        ."Crie um value object e um cast tipado.\nSe o JSON for genuinamente polimórfico, "
        .'adicione-o a ALLOWED_LOOSE_CASTS neste arquivo COM o motivo.',
        implode("\n  ", $violations),
    ));
});

arch('mantém a allowlist honesta: nada listado que já foi resolvido', function (): void {
    $stale = [];

    foreach (ALLOWED_LOOSE_CASTS as $model => $attributes) {
        $casts = (new $model)->getCasts();

        foreach ($attributes as $attribute => $reason) {
            $cast = $casts[$attribute] ?? null;

            if (!is_string($cast) || !isBannedCast($cast)) {
                $stale[] = sprintf('%s::$%s', $model, $attribute);
            }
        }
    }

    expect($stale)->toBe([], sprintf(
        "Estas entradas da allowlist não são mais necessárias — remova:\n  %s",
        implode("\n  ", $stale),
    ));
});
