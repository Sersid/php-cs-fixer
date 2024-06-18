<?php

declare(strict_types=1);

namespace Samson\PhpCsFixer\Fixer\Bitrix;

use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use Samson\PhpCsFixer\Fixer\AbstractFixer;
use SplFileInfo;

final class IncludeModuleFixer extends AbstractFixer
{
    public function isCandidate(Tokens $tokens): bool
    {
        return $tokens->isAllTokenKindsFound([T_STRING, T_DOUBLE_COLON]);
    }

    public function isRisky(): bool
    {
        return false;
    }

    public function fix(SplFileInfo $file, Tokens $tokens): void
    {
        $start = 0;
        while (true) {
            $foundTokens = $tokens->findSequence(
                [
                    new Token([T_STRING, 'CModule']),
                    new Token([T_DOUBLE_COLON, '::']),
                    new Token([T_STRING, 'IncludeModule']),
                ],
                $start
            );

            if ($foundTokens === null) {
                return;
            }

            $classNameIndex = (int)array_key_first($foundTokens);
            $tokens[$classNameIndex] = new Token([T_STRING, '\Bitrix\Main\Loader']);

            $methodNameIndex = (int)array_key_last($foundTokens);
            $tokens[$methodNameIndex] = new Token([T_STRING, 'includeModule']);

            $start = $methodNameIndex + 1;
        }
    }

    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition(
            'Fix include module in Bitrix.',
            [
                new CodeSample(
                    '<?php CModule::IncludeModule("main"); ?>'
                ),
            ],
        );
    }

    public function getName(): string
    {
        return 'Samson/include_module';
    }
}
