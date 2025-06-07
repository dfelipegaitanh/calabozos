<?php

declare(strict_types=1);

use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\Config\RectorConfig;

return RectorConfig::configure()
    // register single rule
    // here we can define, what prepared sets of rules will be applied
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        typeDeclarations: true,
        privatization: true,
        earlyReturn: true,
        strictBooleans: true,
    )->withRules([
        NewlineAfterStatementRector::class,
    ])->withPaths([
        __DIR__.'/app',
        __DIR__.'/tests',
        __DIR__.'/routes',
        __DIR__.'/config',
    ]);
