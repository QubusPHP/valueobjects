<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\DateTime;

use Carbon\CarbonTimeZone;
use PHPUnit\Framework\TestCase;
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

        $this->assertTrue($fromNativeTimeZone->equals($constructedTimeZone));
    }

    public function testFromNativeCarbonTimeZone()
    {
        $nativeTimeZone = new CarbonTimeZone('Europe/Madrid');
        $timeZoneFromNative = TimeZone::fromNativeCarbonTimeZone($nativeTimeZone);

        $constructedTimeZone = new TimeZone(new StringLiteral('Europe/Madrid'));

        $this->assertTrue($timeZoneFromNative->equals($constructedTimeZone));
    }

    public function testDefaultTz()
    {
        $timeZone = TimeZone::fromDefault();
        $this->assertEquals(date_default_timezone_get(), strval($timeZone));
    }

    public function testSameValueAs()
    {
        $timeZone1 = new TimeZone(new StringLiteral('Europe/Madrid'));
        $timeZone2 = new TimeZone(new StringLiteral('Europe/Madrid'));
        $timeZone3 = new TimeZone(new StringLiteral('Europe/Berlin'));

        $this->assertTrue($timeZone1->equals($timeZone2));
        $this->assertFalse($timeZone1->equals($timeZone3));

        $mock = $this->getMockBuilder(ValueObject::class)
            ->getMock();
        $this->assertFalse($timeZone1->equals($mock));
    }

    public function testGetName()
    {
        $name = new StringLiteral('Europe/Madrid');
        $timeZone = new TimeZone($name);

        $this->assertTrue($name->equals($timeZone->getName()));
    }

    public function testToNativeCarbonTimeZone()
    {
        $nativeTimeZone = new CarbonTimeZone('Europe/Madrid');
        $timeZone = new TimeZone(new StringLiteral('Europe/Madrid'));

        $this->assertEquals($nativeTimeZone, $timeZone->toNativeCarbonTimeZone());
    }

    public function testToString()
    {
        $timeZone = new TimeZone(new StringLiteral('Europe/Madrid'));

        $this->assertEquals('Europe/Madrid', $timeZone->__toString());
    }

    /**
     * @expectedException \Qubus\ValueObjects\DateTime\Exception\InvalidTimeZoneException
     */
    public function testExceptionOnInvalidTimeZoneName()
    {
        $timeZone = new TimeZone(new StringLiteral('Mars/Phobos'));
    }
}
