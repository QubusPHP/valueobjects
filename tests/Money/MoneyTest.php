<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Test\Money;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Money\Money;
use Qubus\ValueObjects\Number\Real;
use Qubus\ValueObjects\Money\Currency;
use Qubus\ValueObjects\Number\Integer;
use Qubus\ValueObjects\Money\CurrencyCode;
use Qubus\ValueObjects\ValueObjectInterface;

class MoneyTest extends TestCase
{
    public function setUp()
    {
        # When tests run in a different locale, this might affect the decimal-point character and thus the validation
        # of floats. This makes sure the tests run in a locale that the tests are known to be working in.
        setlocale(LC_ALL, "en_US.UTF-8");
    }

    public function testFromNative()
    {
        $fromNativeMoney = Money::fromNative(2100, 'EUR');
        $constructedMoney = new Money(new Integer(2100), new Currency(CurrencyCode::EUR()));

        $this->assertTrue($fromNativeMoney->equals($constructedMoney));
    }

    public function testSameValueAs()
    {
        $eur = new Currency(CurrencyCode::EUR());
        $usd = new Currency(CurrencyCode::USD());

        $money1 = new Money(new Integer(1200), $eur);
        $money2 = new Money(new Integer(1200), $eur);
        $money3 = new Money(new Integer(34607), $usd);

        $this->assertTrue($money1->equals($money2));
        $this->assertTrue($money2->equals($money1));
        $this->assertFalse($money1->equals($money3));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)
            ->getMock();
        $this->assertFalse($money1->equals($mock));
    }

    public function testGetAmount()
    {
        $eur = new Currency(CurrencyCode::EUR());
        $money = new Money(new Integer(1200), $eur);
        $amount = $money->getAmount();

        $this->assertInstanceOf('\Qubus\ValueObjects\Number\Integer', $amount);
        $this->assertSame(1200, $amount->toNative());
    }

    public function testGetCurrency()
    {
        $eur = new Currency(CurrencyCode::EUR());
        $money = new Money(new Integer(1200), $eur);
        $currency = $money->getCurrency();

        $this->assertInstanceOf('\Qubus\ValueObjects\Money\Currency', $currency);
        $this->assertSame('EUR', $currency->getCode()->toNative());
    }

    public function testAdd()
    {
        $eur = new Currency(CurrencyCode::EUR());
        $money = new Money(new Integer(1200), $eur);
        $addendum = new Integer(156);

        $addedMoney = $money->add($addendum);

        $this->assertEquals(1356, $addedMoney->getAmount()->toNative());
    }

    public function testAddNegative()
    {
        $eur = new Currency(CurrencyCode::EUR());
        $money = new Money(new Integer(1200), $eur);
        $addendum = new Integer(- 120);

        $addedMoney = $money->add($addendum);

        $this->assertEquals(1080, $addedMoney->getAmount()->toNative());
    }

    public function testMultiply()
    {
        $eur = new Currency(CurrencyCode::EUR());
        $money = new Money(new Integer(1200), $eur);
        $multiplier = new Real(1.2);

        $addedMoney = $money->multiply($multiplier);

        $this->assertEquals(1440, $addedMoney->getAmount()->toNative());
    }

    public function testMultiplyInverse()
    {
        $eur = new Currency(CurrencyCode::EUR());
        $money = new Money(new Integer(1200), $eur);
        $multiplier = new Real(0.3);

        $addedMoney = $money->multiply($multiplier);

        $this->assertEquals(360, $addedMoney->getAmount()->toNative());
    }

    public function testToString()
    {
        $eur = new Currency(CurrencyCode::EUR());
        $money = new Money(new Integer(1200), $eur);

        $this->assertSame('EUR 1200', $money->__toString());
    }

    public function testDifferentLocaleWithDifferentDecimalCharacter()
    {
        setlocale(LC_ALL, "de_DE.UTF-8");

        $this->testFromNative();
        $this->testSameValueAs();
        $this->testGetAmount();
        $this->testGetCurrency();
        $this->testAdd();
        $this->testAddNegative();
        $this->testMultiply();
        $this->testMultiplyInverse();
        $this->testToString();
    }
}
