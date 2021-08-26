<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\DateTime;

use Carbon\CarbonImmutable;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\DateTime\Month;

use function date;

class MonthTest extends TestCase
{
    public function testNow()
    {
        $month = Month::now();
        Assert::assertEquals(date('F'), $month->toNative());
    }

    public function testFromNativeDateTime()
    {
        $nativeDateTime = new CarbonImmutable('2013-12-1');

        $month = Month::fromNativeCarbonImmutable($nativeDateTime);

        Assert::assertEquals('December', $month->toNative());
    }

    public function testGetNumericValue()
    {
        $month = Month::APRIL();

        Assert::assertEquals(4, $month->getNumericValue());
    }
}
