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
    protected $street;

    protected function setup(): void
    {
        $this->street = new Street(
            new StringLiteral('Abbey Rd'),
            new StringLiteral('3'),
            new StringLiteral('Building A'),
            new StringLiteral('%number% %name%, %elements%')
        );
    }

    public function testFromNative()
    {
        $fromNativeStreet = Street::fromNative('Abbey Rd', '3', 'Building A');
        Assert::True($this->street->equals($fromNativeStreet));
    }

    public function testInvalidFromNative()
    {
        $this->expectException(BadMethodCallException::class);

        Street::fromNative('Abbey Rd');
    }

    public function testequals()
    {
        $street2 = new Street(new StringLiteral('Abbey Rd'), new StringLiteral('3'), new StringLiteral('Building A'));
        $street3 = new Street(new StringLiteral('Orchard Road'), new StringLiteral(''));

        Assert::True($this->street->equals($street2));
        Assert::True($street2->equals($this->street));
        Assert::False($this->street->equals($street3));

        $mock = $this->getMockBuilder(ValueObject::class)
            ->getMock();
        Assert::False($this->street->equals($mock));
    }

    public function testGetName()
    {
        $name = new StringLiteral('Abbey Rd');
        Assert::True($this->street->getName()->equals($name));
    }

    public function testGetNumber()
    {
        $number = new StringLiteral('3');
        Assert::True($this->street->getNumber()->equals($number));
    }

    public function testGetElements()
    {
        $elements = new StringLiteral('Building A');
        Assert::True($this->street->getElements()->equals($elements));
    }

    public function testToString()
    {
        Assert::Same('3 Abbey Rd, Building A', $this->street->__toString());
    }
}
