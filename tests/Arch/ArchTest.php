<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| System-wide architecture rules
|--------------------------------------------------------------------------
|
| These enforce the conventions documented in .ai/guidelines: strict types
| everywhere and no debugging leftovers.
|
*/

arch('application code declares strict types')
    ->expect('App')
    ->toUseStrictTypes();

arch('module code declares strict types')
    ->expect('He4rt')
    ->toUseStrictTypes();

arch('no debugging statements leak into the codebase')
    ->expect(['dd', 'dump', 'ray', 'var_dump', 'var_export'])
    ->not->toBeUsed();
