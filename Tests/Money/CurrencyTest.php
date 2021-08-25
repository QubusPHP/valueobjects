<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Money;

use PHPUnit\Framework\Assert;
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

        Assert::assertTrue($fromNativeCurrency->equals($constructedCurrency));
    }

    public function testSameValueAs()
    {
        $eur1 = new Currency(CurrencyCode::EUR());
        $eur2 = new Currency(CurrencyCode::EUR());
        $usd  = new Currency(CurrencyCode::USD());

        Assert::assertTrue($eur1->equals($eur2));
        Assert::assertTrue($eur2->equals($eur1));
        Assert::assertFalse($eur1->equals($usd));

        $mock = $this->getMockBuilder(ValueObject::class)
            ->getMock();
        Assert::assertFalse($eur1->equals($mock));
    }

    public function testGetCode()
    {
        $cad = new Currency(CurrencyCode::CAD());

        Assert::assertInstanceOf(CurrencyCode::class, $cad->getCode());
        Assert::assertSame('CAD', $cad->getCode()->toNative());
    }

    public function testToString()
    {
        $eur = new Currency(CurrencyCode::EUR());

        Assert::assertSame('EUR', $eur->__toString());
    }
}
