<?php

declare(strict_types=1);

namespace Samson\PhpCsFixer\Fixer\Bitrix;

use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use Samson\PhpCsFixer\Fixer\AbstractFixer;

abstract class AbstractShowFixer extends AbstractFixer
{
    public function isCandidate(Tokens $tokens): bool
    {
        return $tokens->isAllTokenKindsFound([T_VARIABLE, T_OBJECT_OPERATOR, T_STRING]);
    }

    public function isRisky(): bool
    {
        return false;
    }

    public function fix(\SplFileInfo $file, Tokens $tokens): void
    {
        $start = 0;
        while (true) {
            $foundTokens = $tokens->findSequence(
                [
                    new Token([T_VARIABLE, '$APPLICATION']),
                    new Token([T_OBJECT_OPERATOR, '->']),
                    new Token([T_STRING, static::methodName()]),
                ],
                $start,
            );

            if ($foundTokens === null) {
                break;
            }

            $start = array_key_last($foundTokens) + 1;
            $this->doFix($tokens, array_key_first($foundTokens));
        }
    }

    private function doFix(Tokens $tokens, int $variableIndex): void
    {
        $index = $tokens->getPrevMeaningfulToken($variableIndex);
        switch ($tokens[$index]?->getId()) {
            case T_OPEN_TAG_WITH_ECHO:
                $this->fixOpenTagWithEcho($tokens, $index);
                break;
            case T_ECHO:
            case T_PRINT:
                $this->fixEcho($tokens, $index);
                break;
        }
    }

    private function fixOpenTagWithEcho(Tokens $tokens, int $index): void
    {
        $tokens[$index] = new Token([T_OPEN_TAG, '<?php']);
        if (!$tokens[$index + 1]->isWhitespace()) {
            $tokens->insertAt($index + 1, new Token(' '));
        }
    }

    private function fixEcho(Tokens $tokens, int $index): void
    {
        $tokens->clearAt($index);
        if ($tokens[$index + 1]->isWhitespace()) {
            $tokens->clearAt($index + 1);
        }
    }

    abstract protected static function methodName(): string;
}
