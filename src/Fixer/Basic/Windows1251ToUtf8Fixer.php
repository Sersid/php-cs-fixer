<?php

declare(strict_types=1);

namespace Samson\PhpCsFixer\Fixer\Basic;

use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Tokens;
use Samson\PhpCsFixer\Fixer\AbstractFixer;

final class Windows1251ToUtf8Fixer extends AbstractFixer
{
    public const FROM = 'Windows-1251';
    public const TO = 'UTF-8';

    public function isCandidate(Tokens $tokens): bool
    {
        return true;
    }

    public function isRisky(): bool
    {
        return false;
    }

    public function fix(\SplFileInfo $file, Tokens $tokens): void
    {
        $content = $tokens->generateCode();
        if (preg_match("/[\xe0\xe1\xe3-\xff]/", $content)) {
            $code = mb_convert_encoding($content, self::TO, self::FROM);
            $tokens->overrideRange(0, $tokens->count() - 1, Tokens::fromCode($code));
        }
    }

    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition(
            'From Windows-1251 to Utf-8 converter.',
            [
                new CodeSample(
                    iconv(
                        self::TO,
                        self::FROM,
                        '<?php echo "Тестовое сообщение"; ?>'
                    )
                ),
            ],
        );
    }

    public function getName(): string
    {
        return 'Samson/windows1251_to_utf8';
    }
}
