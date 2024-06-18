<?php

declare(strict_types=1);

namespace Samson\PhpCsFixer\Fixer\Bitrix;

use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;

final class ShowTitleFixer extends AbstractShowFixer
{
    protected static function methodName(): string
    {
        return 'ShowTitle';
    }

    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition(
            'Fix show title in Bitrix.',
            [
                new CodeSample(
                    '<?=$APPLICATION->ShowTitle() ?>'
                ),
            ],
        );
    }

    public function getName(): string
    {
        return 'Samson/bitrix_show_title';
    }
}
