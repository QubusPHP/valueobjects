<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Number;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Number\Integer;
use Qubus\ValueObjects\Number\Real;
use Qubus\ValueObjects\ValueObject;

class IntegerTest extends TestCase
{
    public function testToNative()
    {
        $integer = new Integer(5);
        Assert::assertSame(5, $integer->toNative());
    }

    public function testSameValueAs()
    {
        $integer1 = new Integer(3);
        $integer2 = new Integer(3);
        $integer3 = new Integer(45);

        Assert::assertTrue($integer1->equals($integer2));
        Assert::assertTrue($integer2->equals($integer1));
        Assert::assertFalse($integer1->equals($integer3));

        $mock = $this->getMockBuilder(ValueObject::class)
            ->getMock();
        Assert::assertFalse($integer1->equals($mock));
    }

    public function testToString()
    {
        $integer = new Integer(87);
        Assert::assertSame('87', $integer->__toString());
    }

    public function testInvalidNativeArgument()
    {
        new Integer(23.4);

        $this->expectException(TypeException::class);
    }

    public function testZeroToString()
    {
        $zero = new Integer(0);
        Assert::assertSame('0', $zero->__toString());
    }

    public function testToReal()
    {
        $integer = new Integer(5);
        $nativeReal = new Real(5);
        $real = $integer->toReal();

        Assert::assertTrue($real->equals($nativeReal));
    }
}
