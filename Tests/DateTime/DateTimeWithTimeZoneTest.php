<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\DateTime;

use Carbon\CarbonImmutable;
use Carbon\CarbonTimeZone;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\DateTime\Date;
use Qubus\ValueObjects\DateTime\DateTime;
use Qubus\ValueObjects\DateTime\DateTimeWithTimeZone;
use Qubus\ValueObjects\DateTime\Hour;
use Qubus\ValueObjects\DateTime\Minute;
use Qubus\ValueObjects\DateTime\Month;
use Qubus\ValueObjects\DateTime\MonthDay;
use Qubus\ValueObjects\DateTime\Second;
use Qubus\ValueObjects\DateTime\Time;
use Qubus\ValueObjects\DateTime\TimeZone;
use Qubus\ValueObjects\DateTime\Year;
use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Qubus\ValueObjects\ValueObject;

use function date;
use function sprintf;
use function strval;

class DateTimeWithTimeZoneTest extends TestCase
{
    public function testFromNative()
    {
        $fromNativeDateTimeWithTz = DateTimeWithTimeZone::fromNative(
            2013,
            'December',
            21,
            10,
            20,
            34,
            'Europe/Madrid'
        );
        $constructedDateTimeWithTz = new DateTimeWithTimeZone(
            new DateTime(
                new Date(new Year(2013), Month::DECEMBER(), new MonthDay(21)),
                new Time(new Hour(10), new Minute(20), new Second(34))
            ),
            new TimeZone(new StringLiteral('Europe/Madrid'))
        );

        Assert::assertTrue($fromNativeDateTimeWithTz->equals($constructedDateTimeWithTz));
    }

    public function testFromNativeCarbonImmutable()
    {
        $nativeDateTime = new CarbonImmutable(
            sprintf(
                '%d-%d-%d %d:%d:%d',
                2013,
                12,
                6,
                20,
                50,
                10
            ),
            new CarbonTimeZone('Europe/Madrid')
        );

        $dateTimeWithTzFromNative = DateTimeWithTimeZone::fromNativeCarbonImmutable($nativeDateTime);

        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(6));
        $time = new Time(new Hour(20), new Minute(50), new Second(10));
        $timezone = new TimeZone(new StringLiteral('Europe/Madrid'));
        $constructedDateTimeWithTz = new DateTimeWithTimeZone(new DateTime($date, $time), $timezone);

        Assert::assertTrue($dateTimeWithTzFromNative->equals($constructedDateTimeWithTz));
    }

    public function testNow()
    {
        $dateTimeWithTz = DateTimeWithTimeZone::now();
        Assert::assertEquals(date('Y-n-j G:i:s e'), strval($dateTimeWithTz));
    }

    public function testSameValueAs()
    {
        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $time = new Time(new Hour(20), new Minute(50), new Second(10));
        $timeZone = new TimeZone(new StringLiteral('Europe/Madrid'));

        $date3 = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $time3 = new Time(new Hour(20), new Minute(50), new Second(10));
        $timeZone3 = new TimeZone(new StringLiteral('Europe/London'));

        $dateTimeWithTz1 = new DateTimeWithTimeZone(new DateTime($date, $time), $timeZone);
        $dateTimeWithTz2 = new DateTimeWithTimeZone(new DateTime($date, $time), $timeZone);
        $dateTimeWithTz3 = new DateTimeWithTimeZone(new DateTime($date3, $time3), $timeZone3);

        Assert::assertTrue($dateTimeWithTz1->equals($dateTimeWithTz2));
        Assert::assertFalse($dateTimeWithTz1->equals($dateTimeWithTz3));

        $mock = $this->getMockBuilder(ValueObject::class)
            ->getMock();
        Assert::assertFalse($dateTimeWithTz1->equals($mock));
    }

    public function testSameTimestampAs()
    {
        $date1 = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $time1 = new Time(new Hour(20), new Minute(50), new Second(10));
        $timeZone1 = new TimeZone(new StringLiteral('Europe/Madrid'));

        $date2 = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $time2 = new Time(new Hour(19), new Minute(50), new Second(10));
        $timeZone2 = new TimeZone(new StringLiteral('Europe/London'));

        $dateTimeWithTz1 = new DateTimeWithTimeZone(new DateTime($date1, $time1), $timeZone1);
        $dateTimeWithTz2 = new DateTimeWithTimeZone(new DateTime($date2, $time2), $timeZone2);

        Assert::assertFalse($dateTimeWithTz1->sameTimestampAs($dateTimeWithTz2));
        Assert::assertFalse($dateTimeWithTz1->equals($dateTimeWithTz2));

        $mock = $this->getMockBuilder(ValueObject::class)
            ->getMock();
        Assert::assertFalse($dateTimeWithTz1->sameTimestampAs($mock));
    }

    public function testGetDateTime()
    {
        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $time = new Time(new Hour(20), new Minute(50), new Second(10));
        $dateTime = new DateTime($date, $time);
        $timeZone = new TimeZone(new StringLiteral('Europe/Madrid'));
        $dateTimeWithTz = new DateTimeWithTimeZone($dateTime, $timeZone);

        Assert::assertTrue($dateTime->equals($dateTimeWithTz->getDateTime()));
    }

    public function testGetTimeZone()
    {
        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $time = new Time(new Hour(20), new Minute(50), new Second(10));
        $dateTime = new DateTime($date, $time);
        $timeZone = new TimeZone(new StringLiteral('Europe/Madrid'));
        $dateTimeWithTz = new DateTimeWithTimeZone($dateTime, $timeZone);

        Assert::assertTrue($timeZone->equals($dateTimeWithTz->getTimeZone()));
    }

    public function testToNativeDateTime()
    {
        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $time = new Time(new Hour(20), new Minute(50), new Second(10));
        $dateTime = new DateTime($date, $time);
        $timeZone = new TimeZone(new StringLiteral('Europe/Madrid'));
        $dateTimeWithTz = new DateTimeWithTimeZone($dateTime, $timeZone);
        $nativeDateTime = CarbonImmutable::createFromFormat(
            'Y-n-j H:i:s e',
            '2013-12-3 20:50:10 Europe/Madrid'
        );

        Assert::assertEquals($nativeDateTime, $dateTimeWithTz->toNativeCarbonImmutable());
    }

    public function testToString()
    {
        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $time = new Time(new Hour(20), new Minute(50), new Second(10));
        $dateTime = new DateTime($date, $time);
        $timeZone = new TimeZone(new StringLiteral('Europe/Madrid'));
        $dateTimeWithTz = new DateTimeWithTimeZone($dateTime, $timeZone);

        Assert::assertEquals('2013-12-3 20:50:10 Europe/Madrid', $dateTimeWithTz->__toString());
    }
}
