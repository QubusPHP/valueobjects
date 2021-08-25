<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\DateTime;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\DateTime\Year;

use function date;

class YearTest extends TestCase
{
    public function testNow()
    {
        $year = Year::now();
        Assert::assertEquals(date('Y'), $year->toNative());
    }
}
