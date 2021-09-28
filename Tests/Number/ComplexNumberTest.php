<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Number;

use BadMethodCallException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Number\ComplexNumber;
use Qubus\ValueObjects\Number\RealNumber;

use function setlocale;

use const LC_ALL;

class ComplexNumberTest extends TestCase
{
    /** @var ComplexNumber */
    private $complex;

    public function setup(): void
    {
        // When tests run in a different locale, this might affect the decimal-point character and thus the validation
        // of floats. This makes sure the tests run in a locale that the tests are known to be working in.
        setlocale(LC_ALL, "en_US.UTF-8");

        $this->complex = new ComplexNumber(new RealNumber(2.05), new RealNumber(3.2));
    }

    public function testFromNative()
    {
        $fromNativeComplexNumber = ComplexNumber::fromNative(2.05, 3.2);

        Assert::assertTrue($fromNativeComplexNumber->equals($this->complex));
    }

    public function testFromNativeWithWrongNumberOfArgsThrowsError()
    {
        $this->expectException(BadMethodCallException::class);

        ComplexNumber::fromNative(2.05);
    }

    public function testFromPolar()
    {
        $mod = new RealNumber(3.800328933132);
        $arg = new RealNumber(1.0010398733119);
        $fromPolar = ComplexNumber::fromPolar($mod, $arg);

        $nativeModulus  = $this->complex->getModulus();
        $nativeArgument = $this->complex->getArgument();

        Assert::assertFalse($nativeModulus->equals($fromPolar->getModulus()));
        Assert::assertFalse($nativeArgument->equals($fromPolar->getArgument()));
    }

    public function testToNative()
    {
        Assert::assertEquals([2.05, 3.2], $this->complex->toNative());
    }

    public function testGetRealNumber()
    {
        $real = new RealNumber(2.05);

        Assert::assertTrue($real->equals($this->complex->getRealNumber()));
    }

    public function testGetIm()
    {
        $im = new RealNumber(3.2);

        Assert::assertTrue($im->equals($this->complex->getIm()));
    }

    public function testGetModulus()
    {
        $mod = new RealNumber(3.800328933132);

        Assert::assertFalse($mod->equals($this->complex->getModulus()));
    }

    public function testGetArgument()
    {
        $arg = new RealNumber(1.0010398733119);

        Assert::assertFalse($arg->equals($this->complex->getArgument()));
    }

    public function testToString($expectedString = '2.034 - 1.4i')
    {
        $complex = new ComplexNumber(new RealNumber(2.034), new RealNumber(-1.4));
        Assert::assertEquals($expectedString, $complex->__toString());
    }

    public function testNotSameValue()
    {
        Assert::assertFalse($this->complex->equals(new RealNumber(2.035)));
    }

    public function testDifferentLocaleWithDifferentDecimalCharacter()
    {
        setlocale(LC_ALL, "de_DE.UTF-8");

        $this->testFromNative();
        $this->testFromPolar();
        $this->testToNative();
        $this->testGetRealNumber();
        $this->testGetIm();
        $this->testGetModulus();
        $this->testGetArgument();
        $this->testToString('2.034 - 1.4i');
        $this->testNotSameValue();
    }
}
