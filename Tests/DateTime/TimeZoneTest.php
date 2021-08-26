<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\DateTime;

use Carbon\CarbonTimeZone;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\DateTime\Exception\InvalidTimeZoneException;
use Qubus\ValueObjects\DateTime\TimeZone;
use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Qubus\ValueObjects\ValueObject;

use function date_default_timezone_get;
use function strval;

class TimeZoneTest extends TestCase
{
    public function testFromNative()
    {
        $fromNativeTimeZone  = TimeZone::fromNative('Europe/Madrid');
        $constructedTimeZone = new TimeZone(new StringLiteral('Europe/Madrid'));

        Assert::assertTrue($fromNativeTimeZone->equals($constructedTimeZone));
    }

    public function testFromNativeCarbonTimeZone()
    {
        $nativeTimeZone = new CarbonTimeZone('Europe/Madrid');
        $timeZoneFromNative = TimeZone::fromNativeCarbonTimeZone($nativeTimeZone);

        $constructedTimeZone = new TimeZone(new StringLiteral('Europe/Madrid'));

        Assert::assertTrue($timeZoneFromNative->equals($constructedTimeZone));
    }

    public function testDefaultTz()
    {
        $timeZone = TimeZone::fromDefault();
        Assert::assertEquals(date_default_timezone_get(), strval($timeZone));
    }

    public function testSameValueAs()
    {
        $timeZone1 = new TimeZone(new StringLiteral('Europe/Madrid'));
        $timeZone2 = new TimeZone(new StringLiteral('Europe/Madrid'));
        $timeZone3 = new TimeZone(new StringLiteral('Europe/Berlin'));

        Assert::assertTrue($timeZone1->equals($timeZone2));
        Assert::assertFalse($timeZone1->equals($timeZone3));

        $mock = $this->getMockBuilder(ValueObject::class)
            ->getMock();
        Assert::assertFalse($timeZone1->equals($mock));
    }

    public function testGetName()
    {
        $name = new StringLiteral('Europe/Madrid');
        $timeZone = new TimeZone($name);

        Assert::assertTrue($name->equals($timeZone->getName()));
    }

    public function testToNativeCarbonTimeZone()
    {
        $nativeTimeZone = new CarbonTimeZone('Europe/Madrid');
        $timeZone = new TimeZone(new StringLiteral('Europe/Madrid'));

        Assert::assertEquals($nativeTimeZone, $timeZone->toNativeCarbonTimeZone());
    }

    public function testToString()
    {
        $timeZone = new TimeZone(new StringLiteral('Europe/Madrid'));

        Assert::assertEquals('Europe/Madrid', $timeZone->__toString());
    }

    public function testExceptionOnInvalidTimeZoneName()
    {
        $this->expectException(InvalidTimeZoneException::class);

        $timeZone = new TimeZone(new StringLiteral('Mars/Phobos'));
    }
}
