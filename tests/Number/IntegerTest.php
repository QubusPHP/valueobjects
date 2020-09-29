<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Test\Number;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Number\Real;
use Qubus\ValueObjects\Number\Integer;
use Qubus\ValueObjects\ValueObjectInterface;

class IntegerTest extends TestCase
{
    public function testToNative()
    {
        $integer = new Integer(5);
        $this->assertSame(5, $integer->toNative());
    }

    public function testSameValueAs()
    {
        $integer1 = new Integer(3);
        $integer2 = new Integer(3);
        $integer3 = new Integer(45);

        $this->assertTrue($integer1->equals($integer2));
        $this->assertTrue($integer2->equals($integer1));
        $this->assertFalse($integer1->equals($integer3));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)
            ->getMock();
        $this->assertFalse($integer1->equals($mock));
    }

    public function testToString()
    {
        $integer = new Integer(87);
        $this->assertSame('87', $integer->__toString());
    }

    /** @expectedException \Qubus\Exception\Data\TypeException */
    public function testInvalidNativeArgument()
    {
        new Integer(23.4);
    }

    public function testZeroToString()
    {
        $zero = new Integer(0);
        $this->assertSame('0', $zero->__toString());
    }

    public function testToReal()
    {
        $integer = new Integer(5);
        $nativeReal = new Real(5);
        $real = $integer->toReal();

        $this->assertTrue($real->equals($nativeReal));
    }
}
