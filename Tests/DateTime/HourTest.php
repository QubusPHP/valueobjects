<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\DateTime;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\DateTime\Hour;

use function date;

class HourTest extends TestCase
{
    public function testFromNative()
    {
        $fromNativeHour  = Hour::fromNative(21);
        $constructedHour = new Hour(21);

        Assert::assertTrue($fromNativeHour->equals($constructedHour));
    }

    public function testNow()
    {
        $hour = Hour::now();
        Assert::assertEquals(date('G'), $hour->toNative());
    }

    public function testInvalidHour()
    {
        $this->expectException(TypeException::class);

        new Hour(24);
    }
}
