<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\DateTime;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\DateTime\MonthDay;

use function date;

class MonthDayTest extends TestCase
{
    public function fromNative()
    {
        $fromNativeMonthDay  = MonthDay::fromNative(15);
        $constructedMonthDay = new MonthDay(15);

        Assert::assertTrue($fromNativeMonthDay->equals($constructedMonthDay));
    }

    public function testNow()
    {
        $monthDay = MonthDay::now();
        Assert::assertEquals(date('j'), $monthDay->toNative());
    }

    public function testInvalidMonthDay()
    {
        $this->expectException(TypeException::class);

        new MonthDay(32);
    }
}
