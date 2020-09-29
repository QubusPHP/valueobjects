<?php
declare(strict_types=1);

namespace Qubus\ValueObjects\Test\DateTime;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\DateTime\Year;

class YearTest extends TestCase
{
    public function testNow()
    {
        $year = Year::now();
        $this->assertEquals(date('Y'), $year->toNative());
    }
}
