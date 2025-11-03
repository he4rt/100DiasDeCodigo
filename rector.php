<?php

declare(strict_types=1);

use Rector\Caching\ValueObject\Storage\FileCacheStorage;
use Rector\CodingStyle\Rector\PostInc\PostIncDecToPreIncDecRector;
use Rector\Config\RectorConfig;
use Rector\EarlyReturn\Rector\If_\ChangeOrIfContinueToMultiContinueRector;
use Rector\Php70\Rector\StaticCall\StaticCallOnNonStaticToInstanceCallRector;
use Rector\Php83\Rector\ClassMethod\AddOverrideAttributeToOverriddenMethodsRector;
use Rector\Php84\Rector\MethodCall\NewMethodCallWithoutParenthesesRector;
use Rector\TypeDeclaration\Rector\ArrowFunction\AddArrowFunctionReturnTypeRector;
use RectorLaravel\Rector\Class_\ModelCastsPropertyToCastsMethodRector;
use RectorLaravel\Rector\Class_\ReplaceExpectsMethodsInTestsRector;
use RectorLaravel\Rector\Coalesce\ApplyDefaultInsteadOfNullCoalesceRector;
use RectorLaravel\Rector\Empty_\EmptyToBlankAndFilledFuncRector;
use RectorLaravel\Rector\FuncCall\ConfigToTypedConfigMethodCallRector;
use RectorLaravel\Rector\FuncCall\RemoveDumpDataDeadCodeRector;
use RectorLaravel\Rector\MethodCall\RefactorBlueprintGeometryColumnsRector;
use RectorLaravel\Rector\PropertyFetch\ReplaceFakerInstanceWithHelperRector;
use RectorLaravel\Set\LaravelSetList;
use RectorLaravel\Set\LaravelSetProvider;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/app',
        __DIR__.'/bootstrap',
        __DIR__.'/config',
        __DIR__.'/database',
        __DIR__.'/routes',
        __DIR__.'/tests',
    ])
    ->withSkip([__DIR__.'/bootstrap/cache'])
    ->withCache(cacheDirectory: sys_get_temp_dir().'/rector_cache', cacheClass: FileCacheStorage::class)
    ->withImportNames(importShortClasses: false, removeUnusedImports: true)
    ->withRootFiles()
    ->withPhpSets()
    ->withComposerBased(laravel: true)
    ->withSetProviders(LaravelSetProvider::class)
    ->withBootstrapFiles([__DIR__.'/vendor/larastan/larastan/bootstrap.php'])
    ->withPHPStanConfigs([__DIR__.'/phpstan.neon.dist'])
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: true,
        privatization: true,
        instanceOf: true,
        earlyReturn: true,
        carbon: true,
        rectorPreset: true,
        phpunitCodeQuality: true,
    )
    ->withRules([
        ApplyDefaultInsteadOfNullCoalesceRector::class,
        EmptyToBlankAndFilledFuncRector::class,
        ModelCastsPropertyToCastsMethodRector::class,
        RefactorBlueprintGeometryColumnsRector::class,
        ReplaceExpectsMethodsInTestsRector::class,
        ReplaceFakerInstanceWithHelperRector::class,
        ConfigToTypedConfigMethodCallRector::class,
    ])
    ->withSets([
        LaravelSetList::LARAVEL_ARRAYACCESS_TO_METHOD_CALL,
        LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL,
        LaravelSetList::LARAVEL_CODE_QUALITY,
        LaravelSetList::LARAVEL_COLLECTION,
        LaravelSetList::LARAVEL_CONTAINER_STRING_TO_FULLY_QUALIFIED_NAME,
        LaravelSetList::LARAVEL_ELOQUENT_MAGIC_METHOD_TO_QUERY_BUILDER,
        LaravelSetList::LARAVEL_FACADE_ALIASES_TO_FULL_NAMES,
        LaravelSetList::LARAVEL_FACTORIES,
        LaravelSetList::LARAVEL_IF_HELPERS,
        LaravelSetList::LARAVEL_TESTING,
        LaravelSetList::LARAVEL_TYPE_DECLARATIONS,
    ])
    ->withConfiguredRule(RemoveDumpDataDeadCodeRector::class, [
        'dd', 'dump', 'var_dump',
    ])
    ->withSkip([
        AddOverrideAttributeToOverriddenMethodsRector::class,
        ChangeOrIfContinueToMultiContinueRector::class,
        PostIncDecToPreIncDecRector::class,
        AddArrowFunctionReturnTypeRector::class,
        NewMethodCallWithoutParenthesesRector::class,
        StaticCallOnNonStaticToInstanceCallRector::class,
    ]);
