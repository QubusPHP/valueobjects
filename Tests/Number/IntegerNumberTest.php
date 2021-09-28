<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Number;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Number\IntegerNumber;
use Qubus\ValueObjects\Number\RealNumber;
use Qubus\ValueObjects\ValueObject;

class IntegerNumberTest extends TestCase
{
    public function testToNative()
    {
        $integer = new IntegerNumber(5);
        Assert::assertSame(5, $integer->toNative());
    }

    public function testSameValueAs()
    {
        $integer1 = new IntegerNumber(3);
        $integer2 = new IntegerNumber(3);
        $integer3 = new IntegerNumber(45);

        Assert::assertTrue($integer1->equals($integer2));
        Assert::assertTrue($integer2->equals($integer1));
        Assert::assertFalse($integer1->equals($integer3));

        $mock = $this->getMockBuilder(ValueObject::class)
            ->getMock();
        Assert::assertFalse($integer1->equals($mock));
    }

    public function testToString()
    {
        $integer = new IntegerNumber(87);
        Assert::assertSame('87', $integer->__toString());
    }

    public function testInvalidNativeArgument()
    {
        $this->expectException(TypeException::class);

        new IntegerNumber(23.4);
    }

    public function testZeroToString()
    {
        $zero = new IntegerNumber(0);
        Assert::assertSame('0', $zero->__toString());
    }

    public function testToRealNumber()
    {
        $integer = new IntegerNumber(5);
        $nativeRealNumber = new RealNumber(5);
        $real = $integer->toRealNumber();

        Assert::assertTrue($real->equals($nativeRealNumber));
    }
}
