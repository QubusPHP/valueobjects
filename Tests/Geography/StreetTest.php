<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Geography;

use BadMethodCallException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Geography\Street;
use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Qubus\ValueObjects\ValueObject;

class StreetTest extends TestCase
{
    /** @var Street $street */
    protected $street;

    protected function setup(): void
    {
        $this->street = new Street(
            new StringLiteral('Abbey Rd'),
            new StringLiteral('3'),
            new StringLiteral('%number% %name%')
        );
    }

    public function testFromNative()
    {
        $fromNativeStreet = Street::fromNative('Abbey Rd', '3');
        Assert::assertTrue($this->street->equals($fromNativeStreet));
    }

    public function testInvalidFromNative()
    {
        $this->expectException(BadMethodCallException::class);

        Street::fromNative('Abbey Rd');
    }

    public function testequals()
    {
        $street2 = new Street(new StringLiteral('Abbey Rd'), new StringLiteral('3'));
        $street3 = new Street(new StringLiteral('Orchard Road'), new StringLiteral(''));

        Assert::assertTrue($this->street->equals($street2));
        Assert::assertTrue($street2->equals($this->street));
        Assert::assertFalse($this->street->equals($street3));

        $mock = $this->getMockBuilder(ValueObject::class)
            ->getMock();
        Assert::assertFalse($this->street->equals($mock));
    }

    public function testGetName()
    {
        $name = new StringLiteral('Abbey Rd');
        Assert::assertTrue($this->street->getName()->equals($name));
    }

    public function testGetNumber()
    {
        $number = new StringLiteral('3');
        Assert::assertTrue($this->street->getNumber()->equals($number));
    }

    public function testToString()
    {
        Assert::assertSame('3 Abbey Rd', $this->street->__toString());
    }
}
