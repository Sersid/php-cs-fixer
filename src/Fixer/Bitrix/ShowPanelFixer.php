<?php

declare(strict_types=1);

namespace Samson\PhpCsFixer\Fixer\Bitrix;

use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;

final class ShowPanelFixer extends AbstractShowFixer
{
    protected static function methodName(): string
    {
        return 'ShowPanel';
    }

    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition(
            'Fix show panel in Bitrix.',
            [
                new CodeSample(
                    '<?=$APPLICATION->ShowPanel() ?>'
                ),
            ],
        );
    }

    public function getName(): string
    {
        return 'Samson/bitrix_show_panel';
    }
}
