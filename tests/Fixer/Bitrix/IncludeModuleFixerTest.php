<?php
declare(strict_types=1);
namespace Tests\Fixer\Bitrix;

use PhpCsFixer\Fixer\FixerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use Samson\PhpCsFixer\Fixer\Bitrix\IncludeModuleFixer;
use Tests\Fixer\FixerTestCase;

#[CoversClass(IncludeModuleFixer::class)]
final class IncludeModuleFixerTest extends FixerTestCase
{
    protected function getFixer(): FixerInterface
    {
        return new IncludeModuleFixer();
    }

    public static function dataProvider(): iterable
    {
        yield [
            '<?php CModule::IncludeModule("main");',
            '<?php \Bitrix\Main\Loader::includeModule("main");',
        ];

        yield [
            '<?php
CModule::IncludeModule("main");
CModule::IncludeModule("iblock");',
            '<?php
\Bitrix\Main\Loader::includeModule("main");
\Bitrix\Main\Loader::includeModule("iblock");',
        ];

        yield [
            '<?php if (CModule::IncludeModule("main") && CModule::IncludeModule("iblock")) {}',
            '<?php if (\Bitrix\Main\Loader::includeModule("main") && \Bitrix\Main\Loader::includeModule("iblock")) {}'
        ];

        yield [
            '<?php \CModule::IncludeModule("main");',
            '<?php \Bitrix\Main\Loader::includeModule("main");',
        ];

        yield [
            '<?php \My\Vendor\CModule::IncludeModule("main");',
        ];

//        yield [
//            '<?php
//use My\Vendor\CModule;
//
//CModule::IncludeModule("main");',
//        ];

//        yield [
//            '<?php
//use CModule;
//
//CModule::IncludeModule("main");',
//            '<?php
//
//\Bitrix\Main\Loader::includeModule("main");',
//        ];
    }
}
