<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Number;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Number\IntegerNumber;
use Qubus\ValueObjects\Number\Natural;
use Qubus\ValueObjects\Number\RealNumber;
use Qubus\ValueObjects\ValueObject;

use function setlocale;

use const LC_ALL;

class RealNumberTest extends TestCase
{
    public function setUp(): void
    {
        // When tests run in a different locale, this might affect the decimal-point character and thus the validation
        // of floats. This makes sure the tests run in a locale that the tests are known to be working in.
        setlocale(LC_ALL, "en_US.UTF-8");
    }

    public function testFromNative()
    {
        $fromNativeRealNumber  = RealNumber::fromNative(.056);
        $constructedRealNumber = new RealNumber(.056);

        Assert::assertTrue($fromNativeRealNumber->equals($constructedRealNumber));
    }

    public function testToNative()
    {
        $real = new RealNumber(3.4);
        Assert::assertEquals(3.4, $real->toNative());
    }

    public function testSameValueAs()
    {
        $real1 = new RealNumber(5.64);
        $real2 = new RealNumber(5.64);
        $real3 = new RealNumber(6.01);

        Assert::assertTrue($real1->equals($real2));
        Assert::assertTrue($real2->equals($real1));
        Assert::assertFalse($real1->equals($real3));

        $mock = $this->getMockBuilder(ValueObject::class)
            ->getMock();
        Assert::assertFalse($real1->equals($mock));
    }

    public function testInvalidNativeArgument()
    {
        $this->expectException(TypeException::class);

        new RealNumber('invalid');
    }

    public function testToInteger()
    {
        $real          = new RealNumber(3.14);
        $nativeIntegerNumber = new IntegerNumber(3);
        $integer       = $real->toInteger();

        Assert::assertTrue($integer->equals($nativeIntegerNumber));
    }

    public function testToNatural()
    {
        $real          = new RealNumber(3.14);
        $nativeNatural = new Natural(3);
        $natural       = $real->toNatural();

        Assert::assertTrue($natural->equals($nativeNatural));
    }

    public function testToString()
    {
        $real = new RealNumber(.7);
        Assert::assertEquals('0.7', $real->__toString());
    }

    public function testDifferentLocaleWithDifferentDecimalCharacter()
    {
        setlocale(LC_ALL, "de_DE.UTF-8");

        $this->testFromNative();
        $this->testToNative();
        $this->testSameValueAs();
        $this->testToInteger();
        $this->testToNatural();
    }
}
