<?php

declare(strict_types=1);

namespace Samson\PhpCsFixer\Fixer\Bitrix;

use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Analyzer\NamespaceUsesAnalyzer;
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
        $namespaceUsesAnalyzer = new NamespaceUsesAnalyzer();
        foreach ($tokens->getNamespaceDeclarations() as $namespace) {
            foreach ($namespaceUsesAnalyzer->getDeclarationsInNamespace($tokens, $namespace) as $use) {
                if ($use->getShortName() === 'CModule' && $use->getShortName() !== $use->getFullName()) {
                    continue 2;
                }
            }

            $start = $namespace->getScopeStartIndex();
            $end = $namespace->getScopeEndIndex();
            while (true) {
                $foundTokens = $tokens->findSequence(
                    [
                        new Token([T_STRING, 'CModule']),
                        new Token([T_DOUBLE_COLON, '::']),
                        new Token([T_STRING, 'IncludeModule']),
                    ],
                    $start,
                    $end,
                );

                if ($foundTokens === null) {
                    break;
                }

                /** @var int $classNameIndex */
                $classNameIndex = array_key_first($foundTokens);
                /** @var int $methodNameIndex */
                $methodNameIndex = array_key_last($foundTokens);
                $start = $methodNameIndex + 3;

                $prevIndex = $classNameIndex - 1;
                if ($tokens[$prevIndex]->isGivenKind(T_NS_SEPARATOR)) {
                    if ($tokens[$prevIndex - 1]->isGivenKind(T_STRING)) {
                        continue;
                    }
                    $tokens->clearAt($prevIndex);
                }

                $tokens[$classNameIndex] = new Token([T_STRING, '\Bitrix\Main\Loader']);
                $tokens[$methodNameIndex] = new Token([T_STRING, 'includeModule']);
            }
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
