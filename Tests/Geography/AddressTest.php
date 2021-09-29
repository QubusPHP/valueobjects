<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Geography;

use BadMethodCallException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Geography\Address;
use Qubus\ValueObjects\Geography\Country;
use Qubus\ValueObjects\Geography\CountryCode;
use Qubus\ValueObjects\Geography\Street;
use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Qubus\ValueObjects\ValueObject;

class AddressTest extends TestCase
{
    /** @var Address */
    protected $address;

    public function setup(): void
    {
        $this->address = new Address(
            new StringLiteral('Nicolò Pignatelli'),
            new Street(new StringLiteral('via Manara'), new StringLiteral('3')),
            new StringLiteral(''),
            new StringLiteral('Altamura'),
            new StringLiteral('BARI'),
            new StringLiteral('70022'),
            new Country(CountryCode::IT())
        );
    }

    public function testFromNative()
    {
        $fromNativeAddress = Address::fromNative(
            'Nicolò Pignatelli',
            'via Manara',
            '3',
            '',
            'Altamura',
            'BARI',
            '70022',
            'IT'
        );
        Assert::assertTrue($this->address->equals($fromNativeAddress));
    }

    public function testInvalidFromNative()
    {
        $this->expectException(BadMethodCallException::class);

        Address::fromNative('invalid');
    }

    public function testSameValueAs()
    {
        $address2 = new Address(
            new StringLiteral('Nicolò Pignatelli'),
            new Street(new StringLiteral('via Manara'), new StringLiteral('3')),
            new StringLiteral(''),
            new StringLiteral('Altamura'),
            new StringLiteral('BARI'),
            new StringLiteral('70022'),
            new Country(CountryCode::IT())
        );

        $address3 = new Address(
            new StringLiteral('Nicolò Pignatelli'),
            new Street(new StringLiteral('SP159'), new StringLiteral('km 4')),
            new StringLiteral(''),
            new StringLiteral('Altamura'),
            new StringLiteral('BARI'),
            new StringLiteral('70022'),
            new Country(CountryCode::IT())
        );

        Assert::assertTrue($this->address->equals($address2));
        Assert::assertTrue($address2->equals($this->address));
        Assert::assertFalse($this->address->equals($address3));

        $mock = $this->getMockBuilder(ValueObject::class)
            ->getMock();
        Assert::assertFalse($this->address->equals($mock));
    }

    public function testGetName()
    {
        $name = new StringLiteral('Nicolò Pignatelli');
        Assert::assertTrue($this->address->getName()->equals($name));
    }

    public function testGetStreet()
    {
        $street = new Street(new StringLiteral('via Manara'), new StringLiteral('3'));
        Assert::assertTrue($this->address->getStreet()->equals($street));
    }

    public function testGetDistrict()
    {
        $district = new StringLiteral('');
        Assert::assertTrue($this->address->getDistrict()->equals($district));
    }

    public function testGetCity()
    {
        $city = new StringLiteral('Altamura');
        Assert::assertTrue($this->address->getCity()->equals($city));
    }

    public function testGetRegion()
    {
        $region = new StringLiteral('BARI');
        Assert::assertTrue($this->address->getRegion()->equals($region));
    }

    public function testGetPostalCode()
    {
        $code = new StringLiteral('70022');
        Assert::assertTrue($this->address->getPostalCode()->equals($code));
    }

    public function testGetCountry()
    {
        $country = new Country(CountryCode::IT());
        Assert::assertTrue($this->address->getCountry()->equals($country));
    }

    public function testToString()
    {
        $addressString = <<<ADDR
Nicolò Pignatelli
3 via Manara
Altamura BARI 70022
Italy
ADDR;

        Assert::assertSame($addressString, $this->address->__toString());
    }
}
