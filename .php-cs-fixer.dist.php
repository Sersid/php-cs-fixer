<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;
use Symfony\Component\Finder\Finder;

$finder = (new Finder())
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests')
    ->files()
    ->name('/\.php$/')
;

return (new Config())
    ->setFinder($finder)
    ->setParallelConfig(ParallelConfigFactory::detect())
    ->setRules([
        '@PSR12' => true,
    ])
;
