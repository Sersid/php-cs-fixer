<?php

declare(strict_types=1);

namespace Tests\Fixer\Basic;

use PhpCsFixer\Fixer\FixerInterface;
use Samson\PhpCsFixer\Fixer\Basic\Windows1251ToUtf8Fixer;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Fixer\FixerTestCase;

#[CoversClass(Windows1251ToUtf8Fixer::class)]
final class Windows1251ToUtf8FixerTest extends FixerTestCase
{
    protected function getFixer(): FixerInterface
    {
        return new Windows1251ToUtf8Fixer();
    }

    public static function dataProvider(): iterable
    {
        yield [
            iconv(
                Windows1251ToUtf8Fixer::TO,
                Windows1251ToUtf8Fixer::FROM,
                '<?php echo "Тестовое сообщение"; ?>'
            ),
            '<?php echo "Тестовое сообщение"; ?>',
        ];

        yield [
            iconv(
                Windows1251ToUtf8Fixer::TO,
                Windows1251ToUtf8Fixer::FROM,
                '<div>Имя пользователя: <?php echo "Петр"; ?></div>'
            ),
            '<div>Имя пользователя: <?php echo "Петр"; ?></div>',
        ];

        yield [
            '<?php echo "Тестовое сообщение"; ?>',
        ];
    }
}
