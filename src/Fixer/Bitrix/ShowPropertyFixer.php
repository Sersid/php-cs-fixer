<?php

declare(strict_types=1);

namespace Samson\PhpCsFixer\Fixer\Bitrix;

use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;

final class ShowPropertyFixer extends AbstractShowFixer
{
    protected static function methodName(): string
    {
        return 'ShowProperty';
    }

    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition(
            'Fix show property in Bitrix.',
            [
                new CodeSample(
                    '<?=$APPLICATION->ShowProperty("CODE") ?>'
                ),
            ],
        );
    }

    public function getName(): string
    {
        return 'Samson/bitrix_show_property';
    }
}
