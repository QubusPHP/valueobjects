<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Structure;

use BadMethodCallException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Qubus\ValueObjects\Structure\KeyValuePair;
use Qubus\ValueObjects\ValueObject;

class KeyValuePairTest extends TestCase
{
    /** @var KeyValuePair */
    protected $keyValuePair;

    public function setup(): void
    {
        $this->keyValuePair = new KeyValuePair(
            new StringLiteral('key'),
            new StringLiteral('value')
        );
    }

    public function testFromNative()
    {
        $fromNativePair = KeyValuePair::fromNative('key', 'value');
        Assert::assertTrue($this->keyValuePair->equals($fromNativePair));
    }

    public function testInvalidFromNative()
    {
        $this->expectException(BadMethodCallException::class);

        KeyValuePair::fromNative('key', 'value', 'invalid');
    }

    public function testSameValueAs()
    {
        $keyValuePair2 = new KeyValuePair(new StringLiteral('key'), new StringLiteral('value'));
        $keyValuePair3 = new KeyValuePair(new StringLiteral('foo'), new StringLiteral('bar'));

        Assert::assertTrue($this->keyValuePair->equals($keyValuePair2));
        Assert::assertTrue($keyValuePair2->equals($this->keyValuePair));
        Assert::assertFalse($this->keyValuePair->equals($keyValuePair3));

        $mock = $this->getMockBuilder(ValueObject::class)
            ->getMock();
        Assert::assertFalse($this->keyValuePair->equals($mock));
    }

    public function testGetKey()
    {
        Assert::assertEquals('key', $this->keyValuePair->getKey());
    }

    public function testGetValue()
    {
        Assert::assertEquals('value', $this->keyValuePair->getValue());
    }

    public function testToString()
    {
        Assert::assertEquals('key => value', $this->keyValuePair->__toString());
    }
}
