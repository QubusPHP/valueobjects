<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Geography;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Geography\Country;
use Qubus\ValueObjects\Geography\CountryCode;
use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Qubus\ValueObjects\ValueObject;

class CountryTest extends TestCase
{
    public function testFromNative()
    {
        $fromNativeCountry  = Country::fromNative('IT');
        $constructedCountry = new Country(CountryCode::IT());

        $this->assertTrue($constructedCountry->equals($fromNativeCountry));
    }

    public function testSameValueAs()
    {
        $country1 = new Country(CountryCode::IT());
        $country2 = new Country(CountryCode::IT());
        $country3 = new Country(CountryCode::US());

        $this->assertTrue($country1->equals($country2));
        $this->assertFalse($country1->equals($country3));

        $mock = $this->getMockBuilder(ValueObject::class)
            ->getMock();
        $this->assertFalse($country1->equals($mock));
    }

    public function testGetCode()
    {
        $italy = new Country(CountryCode::IT());
        $this->assertTrue($italy->getCode()->equals(CountryCode::IT()));
    }

    public function testGetName()
    {
        $italy = new Country(CountryCode::IT());
        $name  = new StringLiteral('Italy');
        $this->assertTrue($italy->getName()->equals($name));
    }

    public function testToString()
    {
        $italy = new Country(CountryCode::IT());
        $this->assertSame('Italy', $italy->__toString());
    }
}
