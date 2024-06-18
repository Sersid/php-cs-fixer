<?php

declare(strict_types=1);

namespace Tests\Fixer\Bitrix;

use PhpCsFixer\Fixer\FixerInterface;
use Samson\PhpCsFixer\Fixer\Bitrix\ShowPropertyFixer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\Fixer\FixerTestCase;

#[CoversClass(ShowPropertyFixer::class)]
#[TestDox('Tests for ShowPropertyFixer')]
final class ShowPropertyFixerTest extends FixerTestCase
{
    protected function getFixer(): FixerInterface
    {
        return new ShowPropertyFixer();
    }

    public static function dataProvider(): iterable
    {

        yield [
            '<?=$APPLICATION->ShowProperty("header_sidebar", "") ?>',
            '<?php $APPLICATION->ShowProperty("header_sidebar", "") ?>',
        ];

        yield [
            '<?php echo $APPLICATION->ShowProperty("header_sidebar") ?>',
            '<?php $APPLICATION->ShowProperty("header_sidebar") ?>',
        ];

        yield [
            '<?php print $APPLICATION->ShowProperty("header_sidebar") ?>',
            '<?php $APPLICATION->ShowProperty("header_sidebar") ?>',
        ];

        yield [
            '<?php
if ($condition) {
    echo $APPLICATION->ShowProperty("header_sidebar");
} else {
    ?><h1><?= $APPLICATION->ShowProperty("header_sidebar") ?></h1><?php
}
?>',
            '<?php
if ($condition) {
    $APPLICATION->ShowProperty("header_sidebar");
} else {
    ?><h1><?php $APPLICATION->ShowProperty("header_sidebar") ?></h1><?php
}
?>',
        ];
    }
}
