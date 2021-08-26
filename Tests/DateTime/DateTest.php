<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\DateTime;

use Carbon\CarbonImmutable;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\DateTime\Date;
use Qubus\ValueObjects\DateTime\Exception\InvalidDateException;
use Qubus\ValueObjects\DateTime\Month;
use Qubus\ValueObjects\DateTime\MonthDay;
use Qubus\ValueObjects\DateTime\Year;
use Qubus\ValueObjects\ValueObject;

use function date;
use function strval;

class DateTest extends TestCase
{
    public function testFromNative()
    {
        $fromNativeDate = Date::fromNative(2013, 'December', 21);
        $constructedDate = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(21));

        Assert::assertTrue($fromNativeDate->equals($constructedDate));
    }

    public function testFromNativeCarbonImmutable()
    {
        $nativeDate = new CarbonImmutable('2013-12-3');
        $dateFromNative = Date::fromNativeCarbonImmutable($nativeDate);
        $constructedDate = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));

        Assert::assertTrue($dateFromNative->equals($constructedDate));
    }

    public function testNow()
    {
        $date = Date::now();
        Assert::assertEquals(date('Y-n-j'), strval($date));
    }

    public function testAlmostValidDateException()
    {
        $this->expectException(InvalidDateException::class);

        new Date(new Year(2013), Month::FEBRUARY(), new MonthDay(31));
    }

    public function testSameValueAs()
    {
        $date1 = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $date2 = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $date3 = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(5));

        Assert::assertTrue($date1->equals($date2));
        Assert::assertFalse($date1->equals($date3));

        $mock = $this->getMockBuilder(ValueObject::class)->getMock();
        Assert::assertFalse($date1->equals($mock));
    }

    public function testGetYear()
    {
        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $year = new Year(2013);

        Assert::assertTrue($year->equals($date->getYear()));
    }

    public function testGetMonth()
    {
        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $month = Month::DECEMBER();

        Assert::assertTrue($month->equals($date->getMonth()));
    }

    public function testGetDay()
    {
        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $day = new MonthDay(3);

        Assert::assertTrue($day->equals($date->getDay()));
    }

    public function testToNativeCarbonImmutable()
    {
        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $nativeDate = CarbonImmutable::createFromFormat('Y-n-j H:i:s', '2013-12-3 00:00:00');

        Assert::assertEquals($nativeDate, $date->toNativeCarbonImmutable());
    }

    public function testToString()
    {
        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        Assert::assertEquals('2013-12-3', $date->__toString());
    }
}
