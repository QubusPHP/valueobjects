<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Structure;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Number\IntegerNumber;
use Qubus\ValueObjects\Number\Natural;
use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Qubus\ValueObjects\Structure\Collection;
use Qubus\ValueObjects\ValueObject;
use SplFixedArray;

class CollectionTest extends TestCase
{
    /** @var Collection */
    protected $collection;

    public function setup(): void
    {
        $array = new SplFixedArray(3);
        $array->offsetSet(0, new StringLiteral('one'));
        $array->offsetSet(1, new StringLiteral('two'));
        $array->offsetSet(2, new IntegerNumber(3));

        $this->collection = new Collection($array);
    }

    public function testInvalidArgument()
    {
        $this->expectException(TypeException::class);

        $array = SplFixedArray::fromArray(['one', 'two', 'three']);

        new Collection($array);
    }

    public function testFromNative()
    {
        $array = SplFixedArray::fromArray([
            'one',
            'two',
            [1, 2],
        ]);
        $fromNativeCollection = Collection::fromNative($array);

        $innerArray = new Collection(
            SplFixedArray::fromArray([
                new StringLiteral('1'),
                new StringLiteral('2'),
            ])
        );
        $array = SplFixedArray::fromArray([
            new StringLiteral('one'),
            new StringLiteral('two'),
            $innerArray,
        ]);
        $constructedCollection = new Collection($array);

        Assert::assertTrue($fromNativeCollection->equals($constructedCollection));
    }

    public function testSameValueAs()
    {
        $array = SplFixedArray::fromArray([
            new StringLiteral('one'),
            new StringLiteral('two'),
            new IntegerNumber(3),
        ]);
        $collection2 = new Collection($array);

        $array = SplFixedArray::fromArray([
            'one',
            'two',
            [1, 2],
        ]);
        $collection3 = Collection::fromNative($array);

        Assert::assertTrue($this->collection->equals($collection2));
        Assert::assertTrue($collection2->equals($this->collection));
        Assert::assertFalse($this->collection->equals($collection3));

        $mock = $this->getMockBuilder(ValueObject::class)
            ->getMock();
        Assert::assertFalse($this->collection->equals($mock));
    }

    public function testCount()
    {
        $three = new Natural(3);

        Assert::assertTrue($this->collection->count()->equals($three));
    }

    public function testContains()
    {
        $one = new StringLiteral('one');
        $ten = new StringLiteral('ten');

        Assert::assertTrue($this->collection->contains($one));
        Assert::assertFalse($this->collection->contains($ten));
    }

    public function testToArray()
    {
        $array = [
            new StringLiteral('one'),
            new StringLiteral('two'),
            new IntegerNumber(3),
        ];

        Assert::assertEquals($array, $this->collection->toArray());
    }

    public function testToString()
    {
        Assert::assertEquals('Qubus\ValueObjects\Structure\Collection(3)', $this->collection->__toString());
    }
}
