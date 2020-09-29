<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Test\NullValue;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\NullValue\NullValue;

class NullValueTest extends TestCase
{
    /** @expectedException \BadMethodCallException */
    public function testFromNative()
    {
        NullValue::fromNative();
    }

    public function testSameValueAs()
    {
        $null1 = new NullValue();
        $null2 = new NullValue();

        $this->assertTrue($null1->equals($null2));
    }

    public function testCreate()
    {
        $null = NullValue::create();

        $this->assertInstanceOf('Qubus\ValueObjects\NullValue\NullValue', $null);
    }

    public function testToString()
    {
        $foo = new NullValue();
        $this->assertSame('', $foo->__toString());
    }
}
