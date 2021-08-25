<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Person;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Person\Name;
use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Qubus\ValueObjects\ValueObject;

class NameTest extends TestCase
{
    /** @var Name */
    private $name;

    protected function setup(): void
    {
        $this->name = new Name(
            new StringLiteral('foo'),
            new StringLiteral('bar'),
            new StringLiteral('baz')
        );
    }

    public function testFromNative()
    {
        $fromNativeName = Name::fromNative('foo', 'bar', 'baz');

        Assert::assertTrue($fromNativeName->equals($this->name));
    }

    public function testGetFirstName()
    {
        Assert::assertEquals('foo', $this->name->getFirstName());
    }

    public function testGetMiddleName()
    {
        Assert::assertEquals('bar', $this->name->getMiddleName());
    }

    public function testGetLastName()
    {
        Assert::assertEquals('baz', $this->name->getLastName());
    }

    public function testGetFullName()
    {
        Assert::assertEquals('foo bar baz', $this->name->getFullName());
    }

    public function testEmptyFullName()
    {
        $name = new Name(new StringLiteral(''), new StringLiteral(''), new StringLiteral(''));

        Assert::assertEquals('', $name->getFullName());
    }

    public function testSameValueAs()
    {
        $name2 = new Name(
            new StringLiteral('foo'),
            new StringLiteral('bar'),
            new StringLiteral('baz')
        );
        $name3 = new Name(
            new StringLiteral('foo'),
            new StringLiteral(''),
            new StringLiteral('baz')
        );

        Assert::assertTrue($this->name->equals($name2));
        Assert::assertTrue($name2->equals($this->name));
        Assert::assertFalse($this->name->equals($name3));

        $mock = $this->getMockBuilder(ValueObject::class)
            ->getMock();
        Assert::assertFalse($this->name->equals($mock));
    }

    public function testToString()
    {
        Assert::assertEquals('foo bar baz', $this->name->__toString());
    }
}
