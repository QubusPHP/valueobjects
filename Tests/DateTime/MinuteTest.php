<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\DateTime;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\DateTime\Minute;

use function date;
use function intval;

class MinuteTest extends TestCase
{
    public function testFromNative()
    {
        $fromNativeMinute  = Minute::fromNative(11);
        $constructedMinute = new Minute(11);

        $this->assertTrue($fromNativeMinute->equals($constructedMinute));
    }

    public function testNow()
    {
        $minute = Minute::now();
        $this->assertEquals(intval(date('i')), $minute->toNative());
    }

    /** @expectedException \Qubus\Exception\Data\TypeException */
    public function testInvalidMinute()
    {
        new Minute(60);
    }
}
