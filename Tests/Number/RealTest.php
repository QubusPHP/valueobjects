<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Number;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Number\Integer;
use Qubus\ValueObjects\Number\Natural;
use Qubus\ValueObjects\Number\Real;
use Qubus\ValueObjects\ValueObject;

use function setlocale;

use const LC_ALL;

class RealTest extends TestCase
{
    public function setUp(): void
    {
        // When tests run in a different locale, this might affect the decimal-point character and thus the validation
        // of floats. This makes sure the tests run in a locale that the tests are known to be working in.
        setlocale(LC_ALL, "en_US.UTF-8");
    }

    public function testFromNative()
    {
        $fromNativeReal  = Real::fromNative(.056);
        $constructedReal = new Real(.056);

        Assert::assertTrue($fromNativeReal->equals($constructedReal));
    }

    public function testToNative()
    {
        $real = new Real(3.4);
        Assert::assertEquals(3.4, $real->toNative());
    }

    public function testSameValueAs()
    {
        $real1 = new Real(5.64);
        $real2 = new Real(5.64);
        $real3 = new Real(6.01);

        Assert::assertTrue($real1->equals($real2));
        Assert::assertTrue($real2->equals($real1));
        Assert::assertFalse($real1->equals($real3));

        $mock = $this->getMockBuilder(ValueObject::class)
            ->getMock();
        Assert::assertFalse($real1->equals($mock));
    }

    public function testInvalidNativeArgument()
    {
        new Real('invalid');

        $this->expectException(TypeException::class);
    }

    public function testToInteger()
    {
        $real          = new Real(3.14);
        $nativeInteger = new Integer(3);
        $integer       = $real->toInteger();

        Assert::assertTrue($integer->equals($nativeInteger));
    }

    public function testToNatural()
    {
        $real          = new Real(3.14);
        $nativeNatural = new Natural(3);
        $natural       = $real->toNatural();

        Assert::assertTrue($natural->equals($nativeNatural));
    }

    public function testToString($expectedString = '0.7')
    {
        $real = new Real(.7);
        Assert::assertEquals($expectedString, $real->__toString());
    }

    public function testDifferentLocaleWithDifferentDecimalCharacter()
    {
        setlocale(LC_ALL, "de_DE.UTF-8");

        $this->testFromNative();
        $this->testToNative();
        $this->testSameValueAs();
        $this->testToInteger();
        $this->testToNatural();
        $this->testToString('0,7');
    }
}
