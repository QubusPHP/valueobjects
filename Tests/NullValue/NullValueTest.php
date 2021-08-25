<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\NullValue;

use BadMethodCallException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\NullValue\NullValue;

class NullValueTest extends TestCase
{
    public function testFromNative()
    {
        NullValue::fromNative();

        $this->expectException(BadMethodCallException::class);
    }

    public function testSameValueAs()
    {
        $null1 = new NullValue();
        $null2 = new NullValue();

        Assert::assertTrue($null1->equals($null2));
    }

    public function testCreate()
    {
        $null = NullValue::create();

        Assert::assertInstanceOf(NullValue::class, $null);
    }

    public function testToString()
    {
        $foo = new NullValue();
        Assert::assertSame('', $foo->__toString());
    }
}
