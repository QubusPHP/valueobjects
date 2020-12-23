<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Number;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Number\Complex;
use Qubus\ValueObjects\Number\Real;

use function setlocale;

use const LC_ALL;

class ComplexTest extends TestCase
{
    /** @var Complex */
    private $complex;

    public function setup()
    {
        // When tests run in a different locale, this might affect the decimal-point character and thus the validation
        // of floats. This makes sure the tests run in a locale that the tests are known to be working in.
        setlocale(LC_ALL, "en_US.UTF-8");

        $this->complex = new Complex(new Real(2.05), new Real(3.2));
    }

    public function testFromNative()
    {
        $fromNativeComplex = Complex::fromNative(2.05, 3.2);

        $this->assertTrue($fromNativeComplex->equals($this->complex));
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testFromNativeWithWrongNumberOfArgsThrowsError()
    {
        Complex::fromNative(2.05);
    }

    public function testFromPolar()
    {
        $mod = new Real(3.800328933132);
        $arg = new Real(1.0010398733119);
        $fromPolar = Complex::fromPolar($mod, $arg);

        $nativeModulus  = $this->complex->getModulus();
        $nativeArgument = $this->complex->getArgument();

        $this->assertTrue($nativeModulus->equals($fromPolar->getModulus()));
        $this->assertTrue($nativeArgument->equals($fromPolar->getArgument()));
    }

    public function testToNative()
    {
        $this->assertEquals([2.05, 3.2], $this->complex->toNative());
    }

    public function testGetReal()
    {
        $real = new Real(2.05);

        $this->assertTrue($real->equals($this->complex->getReal()));
    }

    public function testGetIm()
    {
        $im = new Real(3.2);

        $this->assertTrue($im->equals($this->complex->getIm()));
    }

    public function testGetModulus()
    {
        $mod = new Real(3.800328933132);

        $this->assertTrue($mod->equals($this->complex->getModulus()));
    }

    public function testGetArgument()
    {
        $arg = new Real(1.0010398733119);

        $this->assertTrue($arg->equals($this->complex->getArgument()));
    }

    public function testToString($expectedString = '2.034 - 1.4i')
    {
        $complex = new Complex(new Real(2.034), new Real(-1.4));
        $this->assertEquals($expectedString, $complex->__toString());
    }

    public function testNotSameValue()
    {
        $this->assertFalse($this->complex->equals(new Real(2.035)));
    }

    public function testDifferentLocaleWithDifferentDecimalCharacter()
    {
        setlocale(LC_ALL, "de_DE.UTF-8");

        $this->testFromNative();
        $this->testFromPolar();
        $this->testToNative();
        $this->testGetReal();
        $this->testGetIm();
        $this->testGetModulus();
        $this->testGetArgument();
        $this->testToString('2,034 - 1,4i');
        $this->testNotSameValue();
    }
}
