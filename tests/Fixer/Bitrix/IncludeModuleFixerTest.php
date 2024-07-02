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
CModule::IncludeModule("sale");',
            '<?php
\Bitrix\Main\Loader::includeModule("main");
\Bitrix\Main\Loader::includeModule("sale");',
        ];

        yield [
            '<?php if (CModule::IncludeModule("main") && CModule::IncludeModule("sale")) {}',
            '<?php if (\Bitrix\Main\Loader::includeModule("main") && \Bitrix\Main\Loader::includeModule("sale")) {}'
        ];

        yield [
            '<?php \CModule::IncludeModule("main");',
            '<?php \Bitrix\Main\Loader::includeModule("main");',
        ];

        yield [
            '<?php if (CModule::IncludeModule("main")&&Loader::includeModule("sale")) {}',
            '<?php if (\Bitrix\Main\Loader::includeModule("main")&&Loader::includeModule("sale")) {}',
        ];

        yield [
            '<?php
\My\Vendor\CModule::IncludeModule("main");
CModule::IncludeModule("main");',
            '<?php
\My\Vendor\CModule::IncludeModule("main");
\Bitrix\Main\Loader::includeModule("main");',
        ];

        yield [
            '<?php \My\Vendor\CModule::IncludeModule("main");',
        ];

        yield [
            '<?php
use CModule;

CModule::IncludeModule("main");',
            '<?php
use CModule;

\Bitrix\Main\Loader::includeModule("main");',
        ];

        yield [
            '<?php
use My\Vendor\CModule;

CModule::IncludeModule("main");',
        ];

        yield [
            '<?php
namespace My\Vendor {
    class CModule {
        public static function IncludeModule(string $module) {}
    }
}

namespace Test {
    use My\Vendor\CModule;

    class Foo {
        public function __construct() {
            CModule::IncludeModule("main");
        }
    }
}',
        ];
    }
}
