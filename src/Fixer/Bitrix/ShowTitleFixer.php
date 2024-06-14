<?php

declare(strict_types=1);

namespace Samson\PhpCsFixer\Fixer\Bitrix;

use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use Samson\PhpCsFixer\Fixer\AbstractFixer;

final class ShowTitleFixer extends AbstractFixer
{
    public function isCandidate(Tokens $tokens): bool
    {
        return $tokens->isTokenKindFound(T_STRING);
    }

    public function isRisky(): bool
    {
        return false;
    }

    public function fix(\SplFileInfo $file, Tokens $tokens): void
    {
        foreach ($tokens as $index => $token) {
            if (!$token->isGivenKind(T_STRING) || strtolower($token->getContent()) !== 'showtitle') {
                continue;
            }

            $objectOperatorIndex = $tokens->getPrevNonWhitespace($index);
            if ($objectOperatorIndex === null || $tokens[$objectOperatorIndex]->getContent() !== '->') {
                continue;
            }

            $applicationIndex = $tokens->getPrevNonWhitespace($objectOperatorIndex);
            if ($applicationIndex === null || strtolower($tokens[$applicationIndex]->getContent()) !== '$application') {
                continue;
            }

            $echoIndex = $tokens->getPrevNonWhitespace($applicationIndex);
            if ($echoIndex === null) {
                continue;
            }
            $echoToken = $tokens[$echoIndex];
            if ($echoToken->isGivenKind(T_OPEN_TAG_WITH_ECHO)) {
                $tokens[$echoIndex] = new Token([T_OPEN_TAG, '<?php']);
                if (!$tokens[$echoIndex + 1]->isWhitespace()) {
                    $tokens->insertAt($echoIndex + 1, new Token(' '));
                }
            } elseif ($echoToken->isGivenKind(T_ECHO)) {
                $tokens->clearAt($echoIndex);
                if ($tokens[$echoIndex + 1]->isWhitespace()) {
                    $tokens->clearAt($echoIndex + 1);
                }
            }
        }
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
