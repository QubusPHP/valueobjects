<?php
declare(strict_types=1);

namespace Qubus\ValueObjects\Test\DateTime;

use Carbon\CarbonImmutable;
use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\DateTime\Month;

class MonthTest extends TestCase
{
    public function testNow()
    {
        $month = Month::now();
        $this->assertEquals(date('F'), $month->toNative());
    }

    public function testFromNativeDateTime()
    {
        $nativeDateTime = new CarbonImmutable('2013-12-1');

        $month = Month::fromNativeCarbonImmutable($nativeDateTime);

        $this->assertEquals('December', $month->toNative());
    }

    public function testGetNumericValue()
    {
        $month = Month::APRIL();

        $this->assertEquals(4, $month->getNumericValue());
    }
}
