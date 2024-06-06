<?php
declare(strict_types=1);

use PhpCsFixer\Config;
use Samson\PhpCsFixer\Fixer\PhpTag\WhitespaceAfterOpeningShortTagFixer;
use Symfony\Component\Finder\Finder;

$finder = (new Finder())
    ->in(__DIR__ . '/example')
    ->files()
    ->name('/\.php$/')
;

return (new Config())
    ->registerCustomFixers([
        new WhitespaceAfterOpeningShortTagFixer(),
    ])
    ->setRules([
        // 'linebreak_after_opening_tag' => true,
        'Samson/white_space_after_opening_short_tag' => true,
        // 'no_closing_tag' => true,
        // 'lowercase_cast' => true,
        'full_opening_tag' => true,
    ])
    ->setFinder($finder)
;