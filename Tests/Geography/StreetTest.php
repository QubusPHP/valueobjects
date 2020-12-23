<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Geography;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Geography\Street;
use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Qubus\ValueObjects\ValueObject;

class StreetTest extends TestCase
{
    protected $street;

    protected function setup()
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
        $this->assertTrue($this->street->equals($fromNativeStreet));
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testInvalidFromNative()
    {
        Street::fromNative('Abbey Rd');
    }

    public function testequals()
    {
        $street2 = new Street(new StringLiteral('Abbey Rd'), new StringLiteral('3'), new StringLiteral('Building A'));
        $street3 = new Street(new StringLiteral('Orchard Road'), new StringLiteral(''));

        $this->assertTrue($this->street->equals($street2));
        $this->assertTrue($street2->equals($this->street));
        $this->assertFalse($this->street->equals($street3));

        $mock = $this->getMockBuilder(ValueObject::class)
            ->getMock();
        $this->assertFalse($this->street->equals($mock));
    }

    public function testGetName()
    {
        $name = new StringLiteral('Abbey Rd');
        $this->assertTrue($this->street->getName()->equals($name));
    }

    public function testGetNumber()
    {
        $number = new StringLiteral('3');
        $this->assertTrue($this->street->getNumber()->equals($number));
    }

    public function testGetElements()
    {
        $elements = new StringLiteral('Building A');
        $this->assertTrue($this->street->getElements()->equals($elements));
    }

    public function testToString()
    {
        $this->assertSame('3 Abbey Rd, Building A', $this->street->__toString());
    }
}
