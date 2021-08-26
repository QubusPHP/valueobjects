<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\DateTime;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\DateTime\Second;

use function date;
use function intval;

class SecondTest extends TestCase
{
    public function testFromNative()
    {
        $fromNativeSecond  = Second::fromNative(13);
        $constructedSecond = new Second(13);

        Assert::assertTrue($fromNativeSecond->equals($constructedSecond));
    }

    public function testNow()
    {
        $second = Second::now();
        Assert::assertEquals(intval(date('s')), $second->toNative());
    }

    public function testInvalidSecond()
    {
        $this->expectException(TypeException::class);

        new Second(60);
    }
}
