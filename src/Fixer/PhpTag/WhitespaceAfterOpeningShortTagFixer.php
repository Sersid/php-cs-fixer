<?php

declare(strict_types=1);

namespace Samson\PhpCsFixer\Fixer\PhpTag;

use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use Samson\PhpCsFixer\Fixer\AbstractFixer;

final class WhitespaceAfterOpeningShortTagFixer extends AbstractFixer
{
    public function isCandidate(Tokens $tokens): bool
    {
        return $tokens->isTokenKindFound(T_OPEN_TAG);
    }

    public function isRisky(): bool
    {
        return false;
    }

    public function fix(\SplFileInfo $file, Tokens $tokens): void
    {
        foreach ($tokens as $index => $token) {
            if (isset($tokens[$index + 1])
                && $token->isGivenKind(T_OPEN_TAG)
                && $token->getContent() === '<?'
                && !$tokens[$index + 1]->isWhitespace()
            ) {
                $tokens->insertAt($index + 1, new Token(' '));
            }
        }
    }

    public function getPriority(): int
    {
        return 99;
    }

    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition(
            'PHP code must contain a white space after opening short tag "<?".',
            [
                new CodeSample(
                    '<?if($condition) {}'
                ),
                new CodeSample(
                    "<?require __DIR__ . './file.php';"
                ),
            ],
        );
    }

    public function getName(): string
    {
        return 'Samson/white_space_after_opening_short_tag';
    }
}
