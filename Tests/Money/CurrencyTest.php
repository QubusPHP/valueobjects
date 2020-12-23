<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Money;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Money\Currency;
use Qubus\ValueObjects\Money\CurrencyCode;
use Qubus\ValueObjects\ValueObject;

class CurrencyTest extends TestCase
{
    public function testFromNative()
    {
        $fromNativeCurrency = Currency::fromNative('EUR');
        $constructedCurrency = new Currency(CurrencyCode::EUR());

        $this->assertTrue($fromNativeCurrency->equals($constructedCurrency));
    }

    public function testSameValueAs()
    {
        $eur1 = new Currency(CurrencyCode::EUR());
        $eur2 = new Currency(CurrencyCode::EUR());
        $usd  = new Currency(CurrencyCode::USD());

        $this->assertTrue($eur1->equals($eur2));
        $this->assertTrue($eur2->equals($eur1));
        $this->assertFalse($eur1->equals($usd));

        $mock = $this->getMockBuilder(ValueObject::class)
            ->getMock();
        $this->assertFalse($eur1->equals($mock));
    }

    public function testGetCode()
    {
        $cad = new Currency(CurrencyCode::CAD());

        $this->assertInstanceOf(CurrencyCode::class, $cad->getCode());
        $this->assertSame('CAD', $cad->getCode()->toNative());
    }

    public function testToString()
    {
        $eur = new Currency(CurrencyCode::EUR());

        $this->assertSame('EUR', $eur->__toString());
    }
}
