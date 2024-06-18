<?php

declare(strict_types=1);

namespace Tests\Fixer\Bitrix;

use PhpCsFixer\Fixer\FixerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use Samson\PhpCsFixer\Fixer\Bitrix\ShowPanelFixer;
use Tests\Fixer\FixerTestCase;

#[CoversClass(ShowPanelFixer::class)]
#[TestDox('Tests for ShowPanelFixer')]
final class ShowPanelFixerTest extends FixerTestCase
{
    protected function getFixer(): FixerInterface
    {
        return new ShowPanelFixer();
    }

    public static function dataProvider(): iterable
    {

        yield [
            '<?=$APPLICATION->ShowPanel() ?>',
            '<?php $APPLICATION->ShowPanel() ?>',
        ];

        yield [
            '<?php echo $APPLICATION->ShowPanel() ?>',
            '<?php $APPLICATION->ShowPanel() ?>',
        ];

        yield [
            '<?php print $APPLICATION->ShowPanel() ?>',
            '<?php $APPLICATION->ShowPanel() ?>',
        ];

        yield [
            '<?php
if ($condition) {
    echo $APPLICATION->ShowPanel();
} else {
    ?><h1><?= $APPLICATION->ShowPanel() ?></h1><?php
}
?>',
            '<?php
if ($condition) {
    $APPLICATION->ShowPanel();
} else {
    ?><h1><?php $APPLICATION->ShowPanel() ?></h1><?php
}
?>',
        ];
    }
}
