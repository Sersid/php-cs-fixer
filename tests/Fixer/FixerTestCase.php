<?php
declare(strict_types=1);

namespace Tests\Fixer;

use PhpCsFixer\Fixer\FixerInterface;
use PhpCsFixer\FixerDefinition\CodeSampleInterface;
use PhpCsFixer\Tokenizer\Tokens;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use SplFileInfo;

abstract class FixerTestCase extends TestCase
{
    private FixerInterface $fixer;

    abstract protected function getFixer(): FixerInterface;

    abstract public static function dataProvider(): iterable;

    protected function setUp(): void
    {
        parent::setUp();
        Tokens::clearCache();
        $this->fixer = $this->getFixer();
    }

    public function testName(): void
    {
        self::assertMatchesRegularExpression('/^[A-Z][a-zA-Z0-9]*\/[a-z][a-z0-9_]*$/', $this->fixer->getName());
    }

    #[DataProvider('dataProvider')]
    public function testFix(string $input, string $expected = null): void
    {
        $tokens = Tokens::fromCode($input);

        $this->fixer->fix(new SplFileInfo(__FILE__), $tokens);

        self::assertSame($expected !== null, $tokens->isChanged());
        self::assertSame($expected ?? $input, $tokens->generateCode());
    }

    #[TestDox('Definition summary must be completed')]
    public function testDefinitionSummary(): void
    {
        $definition = $this->fixer->getDefinition();

        self::assertNotEmpty($definition->getSummary());
        self::assertNotEmpty($definition->getCodeSamples());
    }

    #[TestDox('Definition code samples must be completed')]
    public function testDefinitionCodeSamples(): array
    {
        $definition = $this->fixer->getDefinition();

        self::assertNotEmpty($definition->getCodeSamples());

        return $definition->getCodeSamples();
    }

    /**
     * @param list<CodeSampleInterface> $codeSamples
     */
    #[TestDox('Definition code examples should be fixed')]
    #[Depends('testDefinitionCodeSamples')]
    public function testCheckDefinitionCodeSamples(array $codeSamples): void
    {
        foreach ($codeSamples as $codeSample) {
            $tokens = Tokens::fromCode($codeSample->getCode());
            $this->fixer->fix(new SplFileInfo(__FILE__), $tokens);

            self::assertTrue($tokens->isChanged());
        }
    }
}
