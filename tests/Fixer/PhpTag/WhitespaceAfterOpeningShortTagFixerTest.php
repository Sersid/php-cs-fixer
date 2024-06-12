<?php

declare(strict_types=1);

namespace Tests\Fixer\PhpTag;

use PhpCsFixer\Fixer\FixerInterface;
use Samson\PhpCsFixer\Fixer\PhpTag\WhitespaceAfterOpeningShortTagFixer;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Fixer\FixerTestCase;

#[CoversClass(WhitespaceAfterOpeningShortTagFixer::class)]
final class WhitespaceAfterOpeningShortTagFixerTest extends FixerTestCase
{
    protected function getFixer(): FixerInterface
    {
        return new WhitespaceAfterOpeningShortTagFixer();
    }

    public static function dataProvider(): iterable
    {
        return [
            [
                '<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>',
                '<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>',
            ],
            [
                '<?$tabControl->BeginNextTab();?>',
                '<? $tabControl->BeginNextTab();?>',
            ],
            [
                '	<h2><?$APPLICATION->ShowTitle()?></h2>',
                '	<h2><? $APPLICATION->ShowTitle()?></h2>',
            ],
            [
                "<?require __DIR__ . './file.php'; ",
                "<? require __DIR__ . './file.php'; ",
            ],
            [
                '					<?if($lpEnabled):?>
                        <h1>Hello</h1>
					<? else: ?>
					<?endif?>',
                '					<? if($lpEnabled):?>
                        <h1>Hello</h1>
					<? else: ?>
					<? endif?>',
            ],
            [
                '<? $tabControl->BeginNextTab();?>',
            ],
            [
                '<?',
            ],
            [
                '<?=$text?>',
            ],
        ];
    }
}
