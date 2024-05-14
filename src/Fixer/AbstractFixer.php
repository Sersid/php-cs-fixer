<?php
declare(strict_types=1);

namespace Samson\PhpCsFixer\Fixer;

use PhpCsFixer\Fixer\FixerInterface;

abstract class AbstractFixer implements FixerInterface
{
    public function getPriority(): int
    {
        return 0;
    }

    public function supports(\SplFileInfo $file): bool
    {
        return true;
    }
}