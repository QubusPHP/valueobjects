<?php
declare(strict_types=1);

namespace Qubus\ValueObjects\Test\DateTime;

use Carbon\CarbonImmutable;
use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\DateTime\Hour;
use Qubus\ValueObjects\DateTime\Time;
use Qubus\ValueObjects\DateTime\Minute;
use Qubus\ValueObjects\DateTime\Second;
use Qubus\ValueObjects\ValueObjectInterface;

class TimeTest extends TestCase
{
    public function testFromNative()
    {
        $fromNativeTime = Time::fromNative(10, 4, 50);
        $constructedTime = new Time(new Hour(10), new Minute(4), new Second(50));

        $this->assertTrue($fromNativeTime->equals($constructedTime));
    }

    public function testFromNativeCarbonImmutable()
    {
        $nativeTime = new CarbonImmutable(
            sprintf(
                '%d:%d:%d',
                20,
                10,
                34
            )
        );
        $timeFromNative = Time::fromNativeCarbonImmutable($nativeTime);
        $constructedTime = new Time(new Hour(20), new Minute(10), new Second(34));

        $this->assertTrue($timeFromNative->equals($constructedTime));
    }

    public function testNow()
    {
        $time = Time::now();
        $this->assertEquals(date('G:i:s'), strval($time));
    }

    public function testZero()
    {
        $time = Time::zero();
        $this->assertEquals('0:00:00', strval($time));
    }

    public function testSameValueAs()
    {
        $time1 = new Time(new Hour(20), new Minute(10), new Second(34));
        $time2 = new Time(new Hour(20), new Minute(10), new Second(34));
        $time3 = new Time(new Hour(20), new Minute(1), new Second(10));

        $this->assertTrue($time1->equals($time2));
        $this->assertFalse($time1->equals($time3));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)
            ->getMock();
        $this->assertFalse($time1->equals($mock));
    }

    public function testGetHour()
    {
        $time = new Time(new Hour(20), new Minute(10), new Second(34));
        $hour = new Hour(20);

        $this->assertTrue($hour->equals($time->getHour()));
    }

    public function testGetMinute()
    {
        $time = new Time(new Hour(20), new Minute(10), new Second(34));
        $minute = new Minute(10);

        $this->assertTrue($minute->equals($time->getMinute()));
    }

    public function testGetSecond()
    {
        $time = new Time(new Hour(20), new Minute(10), new Second(34));
        $day = new Second(34);

        $this->assertTrue($day->equals($time->getSecond()));
    }

    public function testToNativeCarbonImmutable()
    {
        $time = new Time(new Hour(20), new Minute(10), new Second(34));
        $nativeTime = CarbonImmutable::createFromFormat('H:i:s', '20:10:34');

        $this->assertEquals($nativeTime, $time->toNativeCarbonImmutable());
    }

    public function testToString()
    {
        $time = new Time(new Hour(20), new Minute(10), new Second(34));
        $this->assertEquals('20:10:34', $time->__toString());
    }
}
