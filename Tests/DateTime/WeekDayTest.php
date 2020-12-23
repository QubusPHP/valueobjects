<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\DateTime;

use Carbon\CarbonImmutable;
use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\DateTime\WeekDay;

use function date;

class WeekDayTest extends TestCase
{
    public function testNow()
    {
        $weekDay = WeekDay::now();
        $this->assertEquals(date('l'), $weekDay->toNative());
    }

    public function testFromNativeCarbonImmutable()
    {
        $nativeDateTime = new CarbonImmutable('2013-12-14');

        $weekDay = WeekDay::fromNativeCarbonImmutable($nativeDateTime);

        $this->assertEquals('Saturday', $weekDay->toNative());
    }

    public function testGetNumericValue()
    {
        $weekDay = WeekDay::SATURDAY();

        $this->assertEquals(6, $weekDay->getNumericValue());
    }
}
