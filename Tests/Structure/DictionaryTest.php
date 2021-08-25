<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Structure;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Number\Integer;
use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Qubus\ValueObjects\Structure\Collection;
use Qubus\ValueObjects\Structure\Dictionary;
use Qubus\ValueObjects\Structure\KeyValuePair;
use SplFixedArray;

class DictionaryTest extends TestCase
{
    /** @var Dictionary */
    protected $dictionary;

    public function setup(): void
    {
        $array = SplFixedArray::fromArray([
            new KeyValuePair(new Integer(0), new StringLiteral('zero')),
            new KeyValuePair(new Integer(1), new StringLiteral('one')),
            new KeyValuePair(new Integer(2), new StringLiteral('two')),
        ]);

        $this->dictionary = new Dictionary($array);
    }

    public function testFromNative()
    {
        $constructedArray = SplFixedArray::fromArray([
            new KeyValuePair(new StringLiteral('0'), new StringLiteral('zero')),
            new KeyValuePair(new StringLiteral('1'), new StringLiteral('one')),
            new KeyValuePair(new StringLiteral('2'), new StringLiteral('two')),
        ]);

        $fromNativeArray = SplFixedArray::fromArray([
            'zero',
            'one',
            'two',
        ]);

        $constructedDictionary = new Dictionary($constructedArray);
        $fromNativeDictionary  = Dictionary::fromNative($fromNativeArray);

        Assert::assertTrue($constructedDictionary->equals($fromNativeDictionary));
    }

    public function testInvalidArgument()
    {
        $array = SplFixedArray::fromArray(['one', 'two', 'three']);

        new Dictionary($array);

        $this->expectException(TypeException::class);
    }

    public function testKeys()
    {
        $array = SplFixedArray::fromArray([
            new Integer(0),
            new Integer(1),
            new Integer(2),
        ]);
        $keys = new Collection($array);

        Assert::assertTrue($this->dictionary->keys()->equals($keys));
    }

    public function testValues()
    {
        $array = SplFixedArray::fromArray([
            new StringLiteral('zero'),
            new StringLiteral('one'),
            new StringLiteral('two'),
        ]);
        $values = new Collection($array);

        Assert::assertTrue($this->dictionary->values()->equals($values));
    }

    public function testContainsKey()
    {
        $one = new Integer(1);
        $ten = new Integer(10);

        Assert::assertTrue($this->dictionary->containsKey($one));
        Assert::assertFalse($this->dictionary->containsKey($ten));
    }

    public function testContainsValue()
    {
        $one = new StringLiteral('one');
        $ten = new StringLiteral('ten');

        Assert::assertTrue($this->dictionary->containsValue($one));
        Assert::assertFalse($this->dictionary->containsValue($ten));
    }
}
