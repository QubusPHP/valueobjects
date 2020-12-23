<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Structure;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Qubus\ValueObjects\Structure\KeyValuePair;
use Qubus\ValueObjects\ValueObject;

class KeyValuePairTest extends TestCase
{
    /** @var KeyValuePair */
    protected $keyValuePair;

    public function setup()
    {
        $this->keyValuePair = new KeyValuePair(
            new StringLiteral('key'),
            new StringLiteral('value')
        );
    }

    public function testFromNative()
    {
        $fromNativePair = KeyValuePair::fromNative('key', 'value');
        $this->assertTrue($this->keyValuePair->equals($fromNativePair));
    }

    /** @expectedException \BadMethodCallException */
    public function testInvalidFromNative()
    {
        KeyValuePair::fromNative('key', 'value', 'invalid');
    }

    public function testSameValueAs()
    {
        $keyValuePair2 = new KeyValuePair(new StringLiteral('key'), new StringLiteral('value'));
        $keyValuePair3 = new KeyValuePair(new StringLiteral('foo'), new StringLiteral('bar'));

        $this->assertTrue($this->keyValuePair->equals($keyValuePair2));
        $this->assertTrue($keyValuePair2->equals($this->keyValuePair));
        $this->assertFalse($this->keyValuePair->equals($keyValuePair3));

        $mock = $this->getMockBuilder(ValueObject::class)
            ->getMock();
        $this->assertFalse($this->keyValuePair->equals($mock));
    }

    public function testGetKey()
    {
        $this->assertEquals('key', $this->keyValuePair->getKey());
    }

    public function testGetValue()
    {
        $this->assertEquals('value', $this->keyValuePair->getValue());
    }

    public function testToString()
    {
        $this->assertEquals('key => value', $this->keyValuePair->__toString());
    }
}
