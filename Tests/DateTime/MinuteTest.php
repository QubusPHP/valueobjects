<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\DateTime;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\DateTime\Minute;

use function date;
use function intval;

class MinuteTest extends TestCase
{
    public function testFromNative()
    {
        $fromNativeMinute  = Minute::fromNative(11);
        $constructedMinute = new Minute(11);

        Assert::assertTrue($fromNativeMinute->equals($constructedMinute));
    }

    public function testNow()
    {
        $minute = Minute::now();
        Assert::assertEquals(intval(date('i')), $minute->toNative());
    }

    public function testInvalidMinute()
    {
        $this->expectException(TypeException::class);

        new Minute(60);
    }
}
