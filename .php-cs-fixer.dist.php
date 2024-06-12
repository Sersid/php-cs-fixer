<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use Symfony\Component\Finder\Finder;

$finder = (new Finder())
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests')
    ->files()
    ->name('/\.php$/')
;

return (new Config())
    ->setFinder($finder)
    ->setRules([
        '@PSR12' => true,
    ])
;
