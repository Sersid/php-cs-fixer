<?php

declare(strict_types=1);

namespace Tests\Fixer\Bitrix;

use PhpCsFixer\Fixer\FixerInterface;
use Samson\PhpCsFixer\Fixer\Bitrix\ShowTitleFixer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\Fixer\FixerTestCase;

#[CoversClass(ShowTitleFixer::class)]
#[TestDox('Tests for ShowTitleFixer')]
final class ShowTitleFixerTest extends FixerTestCase
{
    protected function getFixer(): FixerInterface
    {
        return new ShowTitleFixer();
    }

    public static function dataProvider(): iterable
    {
        yield [
            '<?=$APPLICATION->ShowTitle() ?>',
            '<?php $APPLICATION->ShowTitle() ?>',
        ];
        yield [
            '<?=$APPLICATION -> ShowTitle() ?>',
            '<?php $APPLICATION -> ShowTitle() ?>',
        ];
        yield [
            '<?= $APPLICATION->ShowTitle() ?>',
            '<?php $APPLICATION->ShowTitle() ?>',
        ];
        yield [
            '<?php echo $APPLICATION->ShowTitle() ?>',
            '<?php $APPLICATION->ShowTitle() ?>',
        ];
        yield [
            '<?php
if ($condition) {
    echo $APPLICATION->ShowTitle();
} else {
    ?><h1><?= $APPLICATION->ShowTitle() ?></h1><?php
}
?>',
            '<?php
if ($condition) {
    $APPLICATION->ShowTitle();
} else {
    ?><h1><?php $APPLICATION->ShowTitle() ?></h1><?php
}
?>',
        ];
        yield [
            '<?php $APPLICATION->ShowTitle() ?>',
        ];
        yield [
            '<?php echo $APPLICATION->
// comment
ShowTitle() ?>',
            '<?php $APPLICATION->
// comment
ShowTitle() ?>',
        ];
    }
}
