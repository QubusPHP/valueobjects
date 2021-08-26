<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\DateTime;

use Carbon\CarbonImmutable;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\DateTime\Date;
use Qubus\ValueObjects\DateTime\DateTime;
use Qubus\ValueObjects\DateTime\Hour;
use Qubus\ValueObjects\DateTime\Minute;
use Qubus\ValueObjects\DateTime\Month;
use Qubus\ValueObjects\DateTime\MonthDay;
use Qubus\ValueObjects\DateTime\Second;
use Qubus\ValueObjects\DateTime\Time;
use Qubus\ValueObjects\DateTime\Year;
use Qubus\ValueObjects\ValueObject;

use function date;
use function strval;

class DateTimeTest extends TestCase
{
    public function testFromNative()
    {
        $fromNativeDateTime  = DateTime::fromNative(2013, 'December', 21, 10, 20, 34);
        $constructedDateTime = new DateTime(
            new Date(new Year(2013), Month::DECEMBER(), new MonthDay(21)),
            new Time(new Hour(10), new Minute(20), new Second(34))
        );

        Assert::assertTrue($fromNativeDateTime->equals($constructedDateTime));
    }

    public function testFromNativeCarbonImmutable()
    {
        $nativeDateTime = new CarbonImmutable('2013-12-6 20:50:10');
        $dateTimeFromNative = DateTime::fromNativeCarbonImmutable($nativeDateTime);

        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(6));
        $time = new Time(new Hour(20), new Minute(50), new Second(10));
        $constructedDateTime = new DateTime($date, $time);

        Assert::assertTrue($dateTimeFromNative->equals($constructedDateTime));
    }

    public function testNow()
    {
        $dateTime = DateTime::now();
        Assert::assertEquals(date('Y-n-j G:i:s'), strval($dateTime));
    }

    public function testNullTime()
    {
        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(21));
        $dateTime = new DateTime($date);
        Assert::assertTrue(Time::zero()->equals($dateTime->getTime()));
    }

    public function testSameValueAs()
    {
        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $time = new Time(new Hour(20), new Minute(50), new Second(10));

        $date3 = new Date(new Year(2014), Month::MARCH(), new MonthDay(5));
        $time3 = new Time(new Hour(10), new Minute(52), new Second(40));

        $dateTime1 = new DateTime($date, $time);
        $dateTime2 = new DateTime($date, $time);
        $dateTime3 = new DateTime($date3, $time3);

        Assert::assertTrue($dateTime1->equals($dateTime2));
        Assert::assertFalse($dateTime1->equals($dateTime3));

        $mock = $this->getMockBuilder(ValueObject::class)
            ->getMock();
        Assert::assertFalse($dateTime1->equals($mock));
    }

    public function testGetDate()
    {
        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $time = new Time(new Hour(20), new Minute(50), new Second(10));
        $dateTime = new DateTime($date, $time);

        Assert::assertTrue($date->equals($dateTime->getDate()));
    }

    public function testGetTime()
    {
        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $time = new Time(new Hour(20), new Minute(50), new Second(10));
        $dateTime = new DateTime($date, $time);

        Assert::assertTrue($time->equals($dateTime->getTime()));
    }

    public function testToNativeCarbonImmutable()
    {
        $date           = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $time           = new Time(new Hour(20), new Minute(50), new Second(10));
        $dateTime       = new DateTime($date, $time);
        $nativeDateTime = CarbonImmutable::createFromFormat('Y-n-j H:i:s', '2013-12-3 20:50:10');

        Assert::assertEquals($nativeDateTime, $dateTime->toNativeCarbonImmutable());
    }

    public function testToString()
    {
        $date           = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $time           = new Time(new Hour(20), new Minute(50), new Second(10));
        $dateTime       = new DateTime($date, $time);

        Assert::assertEquals('2013-12-3 20:50:10', $dateTime->__toString());
    }
}
