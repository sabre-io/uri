<?php

/**
 * @copyright Copyright (C) Christoph Wurst (1374172+ChristophWurst@users.noreply.github.com)
 * @author Christoph Wurst (1374172+ChristophWurst@users.noreply.github.com)
 * @license http://sabre.io/license/
 */

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\PHPUnit\AnnotationsToAttributes\Rector\ClassMethod\DataProviderAnnotationToAttributeRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/lib',
        __DIR__.'/tests',
    ])
    ->withPhpSets(false, true)
    ->withRules([
        DataProviderAnnotationToAttributeRector::class,
    ])
    ->withTypeCoverageLevel(0)
    ->withDeadCodeLevel(0)
    ->withCodeQualityLevel(0);
