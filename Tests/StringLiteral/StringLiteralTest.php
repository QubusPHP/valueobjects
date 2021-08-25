<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\StringLiteral;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Qubus\ValueObjects\ValueObject;
use TypeError;

class StringLiteralTest extends TestCase
{
    public function testFromNative()
    {
        $string = StringLiteral::fromNative('foo');
        $constructedString = new StringLiteral('foo');

        Assert::assertTrue($string->equals($constructedString));
    }

    public function testToNative()
    {
        $string = new StringLiteral('foo');
        Assert::assertEquals('foo', $string->toNative());
    }

    public function testSameValueAs()
    {
        $foo1 = new StringLiteral('foo');
        $foo2 = new StringLiteral('foo');
        $bar = new StringLiteral('bar');

        Assert::assertTrue($foo1->equals($foo2));
        Assert::assertTrue($foo2->equals($foo1));
        Assert::assertFalse($foo1->equals($bar));

        $mock = $this->getMockBuilder(ValueObject::class)
            ->getMock();
        Assert::assertFalse($foo1->equals($mock));
    }

    public function testInvalidNativeArgument()
    {
        new StringLiteral(12);

        $this->expectException(TypeError::class);
    }

    public function testIsEmpty()
    {
        $string = new StringLiteral('');

        Assert::assertTrue($string->isEmpty());
    }

    public function testToString()
    {
        $foo = new StringLiteral('foo');
        Assert::assertEquals('foo', $foo->__toString());
    }
}
