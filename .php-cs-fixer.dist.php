<?php
declare(strict_types=1);

use PhpCsFixer\Config;
use Symfony\Component\Finder\Finder;
use Samson\PhpCsFixer\Fixer;

$finder = (new Finder())
    ->in(__DIR__ . '/example')
    ->files()
    ->name('/\.php$/')
;

return (new Config())
    ->registerCustomFixers([
        new Fixer\PhpTag\WhitespaceAfterOpeningShortTagFixer(),
    ])
    ->setRules([
        // 'linebreak_after_opening_tag' => true,
        // 'Samson/white_space_after_opening_short_tag' => true,
        // 'no_closing_tag' => true,
        // 'lowercase_cast' => true,
        'full_opening_tag' => true,
    ])
    ->setFinder($finder)
;