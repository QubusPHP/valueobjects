<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Test\StringLiteral;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\ValueObjectInterface;
use Qubus\ValueObjects\StringLiteral\StringLiteral;

class StringLiteralTest extends TestCase
{
    public function testFromNative()
    {
        $string = StringLiteral::fromNative('foo');
        $constructedString = new StringLiteral('foo');

        $this->assertTrue($string->equals($constructedString));
    }

    public function testToNative()
    {
        $string = new StringLiteral('foo');
        $this->assertEquals('foo', $string->toNative());
    }

    public function testSameValueAs()
    {
        $foo1 = new StringLiteral('foo');
        $foo2 = new StringLiteral('foo');
        $bar = new StringLiteral('bar');

        $this->assertTrue($foo1->equals($foo2));
        $this->assertTrue($foo2->equals($foo1));
        $this->assertFalse($foo1->equals($bar));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)
            ->getMock();
        $this->assertFalse($foo1->equals($mock));
    }

    /** @expectedException \TypeError */
    public function testInvalidNativeArgument()
    {
        new StringLiteral(12);
    }

    public function testIsEmpty()
    {
        $string = new StringLiteral('');

        $this->assertTrue($string->isEmpty());
    }

    public function testToString()
    {
        $foo = new StringLiteral('foo');
        $this->assertEquals('foo', $foo->__toString());
    }
}
