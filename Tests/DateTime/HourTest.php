<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\DateTime;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\DateTime\Hour;

use function date;

class HourTest extends TestCase
{
    public function testFromNative()
    {
        $fromNativeHour  = Hour::fromNative(21);
        $constructedHour = new Hour(21);

        $this->assertTrue($fromNativeHour->equals($constructedHour));
    }

    public function testNow()
    {
        $hour = Hour::now();
        $this->assertEquals(date('G'), $hour->toNative());
    }

    /** @expectedException \Qubus\Exception\Data\TypeException */
    public function testInvalidHour()
    {
        new Hour(24);
    }
}
