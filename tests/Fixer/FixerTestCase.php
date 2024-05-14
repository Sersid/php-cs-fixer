<?php
declare(strict_types=1);

namespace Tests\Fixer;

use PhpCsFixer\Fixer\FixerInterface;
use PhpCsFixer\Tokenizer\Tokens;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SplFileInfo;

abstract class FixerTestCase extends TestCase
{
    abstract protected function getFixer(): FixerInterface;

    abstract public static function dataProvider(): iterable;

    protected function setUp(): void
    {
        parent::setUp();
        Tokens::clearCache();
    }

    #[DataProvider('dataProvider')]
    public function testFix(string $input, string $expected = null): void
    {
        $tokens = Tokens::fromCode($input);

        $fixer = $this->getFixer();
        $fixer->fix(new SplFileInfo(__FILE__), $tokens);

        self::assertSame($expected !== null, $tokens->isChanged());
        self::assertSame($expected ?? $input, $tokens->generateCode());
    }
}
