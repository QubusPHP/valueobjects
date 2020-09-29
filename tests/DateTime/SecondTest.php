<?php
declare(strict_types=1);

namespace Qubus\ValueObjects\Test\DateTime;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\DateTime\Second;

class SecondTest extends TestCase
{
    public function testFromNative()
    {
        $fromNativeSecond  = Second::fromNative(13);
        $constructedSecond = new Second(13);

        $this->assertTrue($fromNativeSecond->equals($constructedSecond));
    }

    public function testNow()
    {
        $second = Second::now();
        $this->assertEquals(intval(date('s')), $second->toNative());
    }

    /** @expectedException \Qubus\Exception\Data\TypeException */
    public function testInvalidSecond()
    {
        new Second(60);
    }
}
